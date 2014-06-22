<?php

namespace Ftven\Build\Common\Command;

use Ftven\Build\Common\Application\Base\AbstractApplication;
use Ftven\Build\Common\Command\Base\AbstractCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class PackageCommand extends AbstractCommand
{
    /**
     *
     */
    protected function configure()
    {
        /** @var AbstractApplication $app */
        $app = $this->getApplication();
        $this
            ->setName('package')
            ->setDescription('Packages the tool to a phar')
            ->addOption('install', null, InputOption::VALUE_OPTIONAL, "Optionnally install the newly created phar into the system directory", '/usr/local/bin/' . $app->getType())
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
        $install = null;

        if (true === $input->hasOption('install')) {
            $install = $input->getOption('install');
        }

        $return = 0;

        passthru('./bin/box build', $return);

        if (0 !== $return) {
            throw new \RuntimeException("An error occured when packaging the tool", 2);
        }

        if (null !== $install) {
            if (true === is_file('./box.json')) {
                $box = @json_decode(file_get_contents('./box.json'), true);
                if (true === is_array($box) && true === isset($box['output'])) {
                    $file = $box['output'];
                } else {
                    /** @var AbstractApplication $app */
                    $app = $this->getApplication();
                    $file = 'ftven-' . $app->getType();
                }
            } else {
                /** @var AbstractApplication $app */
                $app = $this->getApplication();
                $file = 'ftven-' . $app->getType();
            }
            if (true === is_file($install)) {
                if (false === $this->confirm($input, $output, "File '%s' already exist, do you want to replace it with new version", true)) {
                    return;
                }
            }

            $return = 0;

            passthru(sprintf('sudo cp %s %s', $file, $install), $return);

            if (0 < $return) {
                throw new \RuntimeException(sprintf("An error occured when installing the file '%s' to '%s'", $file, $install), 67);
            }
        }
    }
}