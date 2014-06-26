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

use Symfony\Component\Console\Output\OutputInterface;
use Ftven\Build\Common\Command\Base\AbstractCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;
use Herrera\Phar\Update\Manifest;
use Herrera\Phar\Update\Manager;

/**
 * Update Command.
 *
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class UpdateCommand extends AbstractCommand
{
    /**
     * @param string $manifestFilePattern
     */
    public function __construct($manifestFilePattern)
    {
        parent::__construct();

        $this->manifestFilePattern = $manifestFilePattern;
    }
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('update')
            ->setDescription('Updates tool to the latest version')
        ;
    }
    /**
     * @return int|void
     */
    protected function process()
    {
        $managerClass = $this->getParameter('common.services.updateManager.class');

        /** @var Manager $manager */
        $manager = new $managerClass(
            Manifest::loadFile(
                str_replace('{app}', $this->getApplication()->getType(), $this->manifestFilePattern)
            )
        );

        $manager->update($this->getApplication()->getVersion(), true);
    }
}