<?php

namespace Ftven\Build\Common\Command\Generator\Notification\Base;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

use Ftven\Build\Common\Command\Generator\Base\AbstractGeneratorCommand;

abstract class AbstractNotificationGeneratorCommand extends AbstractGeneratorCommand
{
    /**
     * @return mixed
     */
    protected function getNotificationGeneratorType()
    {
        return preg_replace('/notificationgenerator\-notification\-generator/', '', $this->getType());
    }
    /**
     *
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName(sprintf('generate:notification:%s', $this->getNotificationGeneratorType()))
            ->setDescription(sprintf("Generates a new %s notification", str_replace('-', ' ', $this->getNotificationGeneratorType())))
        ;
    }
    /**
     * @return string
     */
    protected function getOutgoingExchange()
    {
        return 'notifications';
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return array
     */
    protected abstract function build(InputInterface $input, OutputInterface $output);
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return array
     */
    protected function generate(InputInterface $input, OutputInterface $output)
    {
        return $this->build($input, $output);
    }
}