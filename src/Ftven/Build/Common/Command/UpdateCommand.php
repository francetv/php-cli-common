<?php

namespace Ftven\Build\Common\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Herrera\Phar\Update\Manifest;
use Herrera\Phar\Update\Manager;

use Ftven\Build\Common\Application\Base\AbstractApplication;

class UpdateCommand extends Command
{
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
     * @return string
     */
    protected function getManifestFile()
    {
        /** @var AbstractApplication $app */
        $app = $this->getApplication();

        return sprintf('http://tools.build.indus.ftven.net/%s/manifest.json', $app->getType());
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = new Manager(Manifest::loadFile($this->getManifestFile()));
        $manager->update($this->getApplication()->getVersion(), true);
    }
}