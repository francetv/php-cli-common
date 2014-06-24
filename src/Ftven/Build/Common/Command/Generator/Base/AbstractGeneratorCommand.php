<?php

namespace Ftven\Build\Common\Command\Generator\Base;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use PhpAmqpLib\Channel\AMQPChannel;

use Ftven\Build\Common\Command\Base\AbstractAmqpCommand;

abstract class AbstractGeneratorCommand extends AbstractAmqpCommand
{
    /**
     * @return mixed
     */
    protected function getGeneratorType()
    {
        return preg_replace('/-generator$/', '', $this->getType());
    }
    /**
     *
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName(sprintf('generate:%s', $this->getGeneratorType()))
            ->setDescription(sprintf("Generates a new %s", str_replace('-', ' ', $this->getGeneratorType())))
        ;
    }
    /**
     * @return string
     */
    protected abstract function getOutgoingExchange();
    /**
     * @param InputInterface $input
     * @param OutputInterface $outputInterface
     *
     * @return array
     */
    protected abstract function generate(InputInterface $input, OutputInterface $outputInterface);
    /**
     * @param AMQPChannel     $channel
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return array
     */
    protected function processAmqp(AMQPChannel $channel, InputInterface $input, OutputInterface $output)
    {
        return [
            $this->getOutgoingExchange() => [
                $this->generate($input, $output),
            ],
        ];
    }
}