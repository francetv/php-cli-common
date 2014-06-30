<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Command\Base;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Ftven\Build\Common\Application\Base\AbstractApplication;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Command\Command;

/**
 * Abstract Command with short hand methods.
 *
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var InputInterface
     */
    protected $input;
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @param InputInterface $input
     *
     * @return $this
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }
    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @param OutputInterface $output
     *
     * @return $this
     */
    public function setOutput($output)
    {
        $this->output = $output;

        return $this;
    }
    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->setInput($input);
        $this->setOutput($output);

        if (!ini_get('date.timezone')) {
            ini_set('date.timezone', 'Europe/Paris');
        }

    }
    /**
     * @return string
     */
    public function getType()
    {
        return strtolower(join(
            '-',
            array_values(
                array_reverse(
                    explode('/',
                        preg_replace(
                            ',^Ftven/Build/[^/]+/Command/,',
                            '',
                            str_replace(
                                '\\',
                                '/',
                                preg_replace(
                                    '/Command$/',
                                    '',
                                    get_class($this)
                                )
                            )
                        )
                    )
                )
            )
        ));
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param $message
     * @param null $default
     *
     * @return string
     */
    protected function prompt(InputInterface $input, OutputInterface $output, $message, $default = null)
    {
        /** @var QuestionHelper $q */
        $q = $this->getHelperSet()->get('question');

        $question = new Question($message . ($default ? (sprintf(' [%s]', $default)) : '') . ' : ', $default);

        $question->setValidator(function ($answer) {
            $len = function_exists('mb_strlen') ? mb_strlen($answer) : strlen($answer);

            if (0 === $len) {
                throw new \RuntimeException("You must enter a value", 23);
            }

            return $answer;
        });

        $question->setMaxAttempts(3);

        $response = $q->ask($input, $output, $question);

        return $response;
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param string $message
     * @param array  $expectedValues
     * @param mixed  $default
     *
     * @return string
     */
    protected function choice(
        InputInterface $input, OutputInterface $output, $message, $expectedValues, $default = null
    )
    {
        /** @var QuestionHelper $q */
        $q = $this->getHelperSet()->get('question');

        $question = new ChoiceQuestion(
            $message . ($default ? (sprintf(' [%s]', $default)) : '') . ' : ',
            $expectedValues,
            $default
        );

        $question->setMaxAttempts(5);

        $response = $q->ask($input, $output, $question);

        return $response;
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param $message
     * @param bool  $default
     *
     * @return string
     */
    protected function confirm(InputInterface $input, OutputInterface $output, $message, $default = null)
    {
        /** @var QuestionHelper $q */
        $q = $this->getHelperSet()->get('question');

        $question = new ConfirmationQuestion(
            $message . ($default ? (sprintf(' [%s]', $default ? 'yes' : 'no')) : '') . ' : ', true === $default
        );

        $question->setMaxAttempts(3);

        $response = $q->ask($input, $output, $question);

        return $response;
    }
    /**
     * @param string $text
     * @param string $separator
     *
     * @return string
     */
    protected function slug($text, $separator = '-')
    {
        return preg_replace('/[^a-z0-9_\-\.]+/', $separator, strtolower($text));
    }
    /**
     * @param OutputInterface $output
     * @param $name
     * @param array $args
     *
     * @return $this
     *
     * @throws \RuntimeException
     */
    protected function executeCommand(OutputInterface $output, $name, $args = [])
    {
        array_unshift($args, 'internal');

        $return = $this->getApplication()->find($name)->run(new ArrayInput($args), $output);

        if (0 !== $return) {
            throw new \RuntimeException(sprintf("An error occured when executing command '%s'", $name), 30);
        }

        return $this;
    }
    /**
     * @return int
     */
    protected function process()
    {
        return 0;
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->process();
    }
    /**
     * @param string $name
     * @param array  $params
     *
     * @return $this
     */
    protected function command($name, $params = [])
    {
        return $this->executeCommand($this->getOutput(), $name, $params);
    }
    /**
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return mixed
     */
    protected function arg($name, $defaultValue = null)
    {
        $value = $this->getInput()->getArgument($name);

        if (null === $value) {
            return $defaultValue;
        }

        return $value;
    }
    /**
     * @param string $name
     *
     * @return bool
     */
    protected function hasArg($name)
    {
        return null !== $this->getInput()->getArgument($name);
    }
    /**
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return mixed|null
     */
    protected function option($name, $defaultValue = null)
    {
        $value = $this->getInput()->getOption($name);

        if (null === $value) {
            return $defaultValue;
        }

        return $value;
    }
    /**
     * @param string $name
     *
     * @return bool
     */
    protected function hasOption($name)
    {
        return null !== $this->getInput()->getOption($name);
    }
    /**
     * @param string $cmd
     * @param bool   $passthru
     *
     * @return array|null|string
     *
     * @throws \RuntimeException
     */
    protected function shell($cmd, $passthru = false)
    {
        $out = [];
        $return = 0;

        if (true === $passthru) {
            passthru(sprintf('%s 2>&1', $cmd), $return);
            $out = null;
        } else {
            exec(sprintf('%s 2>&1', $cmd), $out, $return);
            $out = join(PHP_EOL, $out);
            if ($this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
                $this->getOutput()->writeln($out);
            }
        }

        if (0 < $return) {
            throw new \RuntimeException(sprintf("Error when executing '%s'", $cmd), 50);
        }

        return $out;
    }
    /**
     * @param string $pattern
     *
     * @return string
     */
    protected function _($pattern)
    {
        return call_user_func_array('sprintf', func_get_args());
    }
    /**
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return null|string
     */
    protected function env($name, $defaultValue = null)
    {
        $value = getenv($name);

        if (null === $value || false === $value) {
            return $defaultValue;
        }

        return $value;
    }
    /**
     * @param string $msg
     *
     * @return $this
     */
    protected function out($msg)
    {
        $this->getOutput()->write(call_user_func_array([$this, '_'], func_get_args()));

        return $this;
    }
    /**
     * @param string $msg
     *
     * @return $this
     */
    protected function outln($msg)
    {
        $this->getOutput()->writeln(call_user_func_array([$this, '_'], func_get_args()));

        return $this;
    }
    /**
     * @return AbstractApplication
     */
    public function getApplication()
    {
        return parent::getApplication();
    }
    /**
     * @param string $key
     *
     * @return mixed
     */
    protected function get($key)
    {
        return $this->getApplication()->getContainer()->get($key);
    }
    /**
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return mixed|null
     */
    protected function getParameter($name, $defaultValue = null)
    {
        if (false === $this->getApplication()->getContainer()->hasParameter($name)) {
            return $defaultValue;
        }

        return $this->getApplication()->getContainer()->getParameter($name);
    }
    protected function describe()
    {
        return [];
    }
    /**
     *
     */
    protected function configure()
    {
        parent::configure();

        $infos = $this->describe();

        if (true === isset($infos['name'])) $this->setName($infos['name']);
        if (true === isset($infos['description'])) $this->setDescription($infos['description']);

        if (true === isset($infos['arguments']) && true === is_array($infos['arguments'])) {
            foreach($infos['arguments'] as $name => $argument) {
                $this->addArgument(
                    $name,
                    true === isset($argument['optional']) && true === $argument['optional']
                        ? InputArgument::OPTIONAL
                        : (
                            isset($argument['array']) && true === $argument['array']
                                ? InputArgument::IS_ARRAY
                                : InputArgument::REQUIRED
                        ),
                    true === isset($argument['description']) ? $argument['description'] : null,
                    true === isset($argument['default']) ? $argument['default'] : null
                );
            }
        }
        if (true === isset($infos['options']) && true === is_array($infos['options'])) {
            foreach($infos['options'] as $name => $option) {
                $this->addOption(
                    $name,
                    true === isset($option['shortcut']) ? $option['shortcut'] : null,
                    true === isset($option['optional']) && true === $option['optional']
                        ? InputOption::VALUE_OPTIONAL
                        : (
                            isset($option['array']) && true === $option['array']
                                ? InputOption::VALUE_IS_ARRAY
                                : (
                                    isset($option['flag']) ? InputOption::VALUE_NONE : InputOption::VALUE_REQUIRED
                                )
                        ),
                    true === isset($option['description']) ? $option['description'] : null,
                    true === isset($option['default']) ? $option['default'] : null
                );
            }
        }

        return $this;
    }

}