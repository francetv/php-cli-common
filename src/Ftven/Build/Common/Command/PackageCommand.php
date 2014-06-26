<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Command;

use Ftven\Build\Common\Command\Base\AbstractCommand;
use Symfony\Component\Console\Input\InputOption;
use Ftven\Build\Common\Service\BoxService;

/**
 * Package command.
 *
 * @author Olivier Hoareau olivier@phppro.fr>
 */
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