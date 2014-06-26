<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Command\Generator\Base;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use PhpAmqpLib\Channel\AMQPChannel;

use Ftven\Build\Common\Command\Base\AbstractAmqpCommand;

/**
 * Abstract Generator Command that will handle provider features using AMQP.
 *
 * @author Olivier Hoareau olivier@phppro.fr>
 */
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