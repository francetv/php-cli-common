<?php

namespace Ftven\Build\Common\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Ftven\Build\Common\Command\Base\AbstractCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;
use Herrera\Phar\Update\Manifest;
use Herrera\Phar\Update\Manager;

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