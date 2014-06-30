<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Command\Agent\Base;

use Ftven\Build\Common\Command\Base\AbstractAmqpCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use PhpAmqpLib\Channel\AMQPChannel;


/**
 * Abstract Agent Command that will handle provider/consumer features using AMQP
 *
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
abstract class AbstractAgentCommand extends AbstractAmqpCommand
{
    /**
     * @return mixed
     */
    public function getAgentType()
    {
        return preg_replace('/agent\-agent$/', '', $this->getType());
    }
    /**
     *
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName(sprintf('agent:%s', $this->getAgentType()))
            ->setDescription(sprintf("Starts a new instance of a %s agent", $this->getAgentType()))
        ;
    }
    /**
     * @param AMQPChannel     $channel
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return array
     */
    protected function processAmqp(AMQPChannel $channel, InputInterface $input, OutputInterface $output)
    {
        while (count($channel->callbacks)) {
            $channel->wait();
        }

        return [];
    }
}