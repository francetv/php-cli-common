<?php

namespace Ftven\Build\Common\Command;

use Ftven\Build\Common\Command\Base\AbstractCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

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
        ;
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $return = 0;

        passthru('./bin/box build', $return);

        if (0 !== $return) {
            throw new \RuntimeException("An error occured when packaging the tool", 2);
        }
    }
}