<?php

namespace Ftven\Build\Common\Application\Base;

use Ftven\Build\Common\Command\PackageCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;

use Ftven\Build\Common\Command\UpdateCommand;

abstract class AbstractApplication extends Application
{
    /**
     * @return string
     */
    public function getType()
    {
        return strtolower(preg_replace('/Application$/', '', basename(str_replace('\\', '/', get_class($this)))));
    }
    /**
     *
     */
    public function __construct()
    {
        parent::__construct(sprintf('ftven-%s', $this->getType()), '@package_version@');
    }
    /**
     * @return Command[]
     */
    protected function registerCommands()
    {
        return [];
    }
    /**
     * @return Command[]
     */
    protected function registerCommonCommands()
    {
        $commands = [
            new UpdateCommand(),
        ];

        if (is_file(getcwd() . '/box.json') && is_file(getcwd() . '/bin/box')) {
            $commands[] = new PackageCommand();
        }

        return $commands;
    }
    /**
     * @return array|Command[]
     */
    protected function getDefaultCommands()
    {
        return array_merge(
            parent::getDefaultCommands(),
            $this->registerCommonCommands(),
            $this->registerCommands()
        );
    }
}