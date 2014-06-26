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
use Ftven\Build\Common\Service\PhpunitService;
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
     * @throws \Exception
     */
    protected function process()
    {
        $install = null;

        if (true === $this->hasOption('install')) {
            $install = str_replace('%name%', $this->getApplication()->getType(), $this->option('install'));
        }

        /** @var PhpunitService $phpunitService */
        $phpunitService = $this->get('common.services.phpunit');

        if (true === $phpunitService->hasSupport()) {
            $this->out("Executing PHPUnit tests...");
            $start = microtime(true);
            try {
                $phpunitService->test();
            } catch (\Exception $e) {
                $this->outln("\r                            \r<error>FAIL</error> PHPUnit tests errors");
                return 1;
            }
            $duration = microtime(true) - $start;
            $this->out("\r                            \r<info>OK</info> PHPUnit tests successfully executed in %.1ds", $duration);
        }

        $this->out("Packaging the tool using Box...");
        $start = microtime(true);
        try {
            /** @var BoxService $boxService */
            $boxService = $this->get('common.services.box');

            $boxService->build(null, $install);
        } catch (\Exception $e) {
            $this->outln("\r                                 \r<error>FAIL</error> Box packaging errors");
            return 2;
        }
        $duration = microtime(true) - $start;
        $this->out(
            "\r                                      \r<info>OK</info> Box package successfully created in %.1ds%s", $duration, $install ? " in $install" : ''
        );

        return 0;
    }
}