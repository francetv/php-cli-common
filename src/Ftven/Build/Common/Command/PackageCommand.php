<?php

namespace Ftven\Build\Common\Command;

use Ftven\Build\Common\Command\Base\AbstractCommand;
use Symfony\Component\Console\Input\InputOption;
use Ftven\Build\Common\Service\BoxService;

class PackageCommand extends AbstractCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('package')
            ->setDescription('Packages the tool to a phar')
            ->addOption(
                'install', null, InputOption::VALUE_OPTIONAL,
                "Optionnally install the newly created phar into the system directory", '/usr/local/bin/%name%'
            )
        ;
    }
    /**
     * @return int|void
     *
     * @throws \RuntimeException
     */
    protected function process()
    {
        $install = null;

        if (true === $this->hasOption('install')) {
            $install = str_replace('%name%', $this->getApplication()->getType(), $this->option('install'));
        }

        /** @var BoxService $boxService */
        $boxService = $this->get('common.services.box');

        $boxService->build(null, $install);
    }
}