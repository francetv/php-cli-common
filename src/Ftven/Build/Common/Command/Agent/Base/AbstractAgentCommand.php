<?php

namespace Ftven\Build\Common\Command\Agent\Base;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use PhpAmqpLib\Channel\AMQPChannel;

use Ftven\Build\Common\Command\Base\AbstractAmqpCommand;

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