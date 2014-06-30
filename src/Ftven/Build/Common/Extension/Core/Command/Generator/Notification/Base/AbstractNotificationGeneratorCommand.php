<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Command\Generator\Notification\Base;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

use Ftven\Build\Common\Command\Generator\Base\AbstractGeneratorCommand;

/**
 * Abstract Notification Generator that will handle sending notification message using AMQP.
 *
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
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
            ->setDescription(
                sprintf("Generates a new %s notification", str_replace('-', ' ', $this->getNotificationGeneratorType()))
            )
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