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

use Ftven\Build\Common\Extension\Core\Feature\ApplicationAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\EnvironmentAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\InteractiveAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\StringFormatterTrait;
use Ftven\Build\Common\Extension\Core\Feature\HelperSetAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\OutputAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\InputAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\SluggerTrait;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
abstract class AbstractCommand extends Command
{
    use InteractiveAwareTrait;
    use ApplicationAwareTrait;
    use EnvironmentAwareTrait;
    use StringFormatterTrait;
    use SluggerTrait;
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
     * @return array
     */
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