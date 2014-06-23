<?php

namespace Ftven\Build\Common\Command\Base;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

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
                throw new \RuntimeException("Vous devez saisir une valeur", 23);
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
     * @param $message
     * @param bool  $default
     *
     * @return string
     */
    protected function confirm(InputInterface $input, OutputInterface $output, $message, $default = null)
    {
        /** @var QuestionHelper $q */
        $q = $this->getHelperSet()->get('question');

        $question = new ConfirmationQuestion($message . ($default ? (sprintf(' [%s]', $default ? 'yes' : 'no')) : '') . ' : ', true === $default);

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
}