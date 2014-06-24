<?php

namespace Ftven\Build\Common\Command\Base;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractAmqpCommand extends AbstractCommand
{
    /**
     *
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->addOption('amqp-host', 'w', InputOption::VALUE_REQUIRED, "Host/IP of the AMQP server", '127.0.0.1')
            ->addOption('amqp-port', 'p', InputOption::VALUE_REQUIRED, "Port of the AMQP server", 5672)
            ->addOption('amqp-user', 'u', InputOption::VALUE_REQUIRED, "User of the AMQP server", 'guest')
            ->addOption('amqp-pass', 'pw', InputOption::VALUE_REQUIRED, "Password of the AMQP server", 'guest')
            ->addOption('amqp-vhost', 'vh', InputOption::VALUE_REQUIRED, "Password of the AMQP server", '/')
            ->addOption('amqp-noop', 'x', InputOption::VALUE_NONE, "Enables the message simulator/mock mode (do nothing, black hole)")
            ->addOption('amqp-dump', 'd', InputOption::VALUE_NONE, "Do not send the queue messages, dump them to the console")
        ;
    }
    /**
     * @param AMQPChannel $channel
     * @param string      $name
     * @param array       $options
     *
     * @return $this
     */
    protected function createQueue(AMQPChannel $channel, $name, $options = [])
    {
        if (false === is_array($options)) {
            $options = [];
        }

        $options = array_merge(
            [
                'passive'    => false,
                'durable'    => true,
                'exclusive'  => false,
                'autoDelete' => false,
                'noWait'     => false,
                'arguments'  => null,
                'ticket'     => null,
            ],
            $options
        );

        $channel->queue_declare(
            $name,
            $options['passive'],
            $options['durable'],
            $options['exclusive'],
            $options['autoDelete'],
            $options['noWait'],
            $options['arguments'],
            $options['ticket']
        );

        if (true === isset($options['exchange'])) {
            $this->bindQueueToExchange($channel, $name, $options['exchange'], isset($options['routing_key']) ? $options['routing_key'] : null);
        }

        if (true === isset($options['consumer'])) {
            $this->addConsumer(
                $channel,
                $name,
                $options['consumer'],
                true === isset($options['tag']) ? $options['tag'] : null
            );
        }

        return $this;
    }
    /**
     * @param AMQPChannel $channel
     * @param string      $name
     * @param array       $options
     *
     * @return $this
     */
    protected function createExchange(AMQPChannel $channel, $name, $options = [])
    {
        if (false === is_array($options)) {
            $options = [];
        }

        $options = array_merge(
            [
                'type'       => 'direct',
                'passive'    => false,
                'durable'    => true,
                'autoDelete' => false,
                'internal'   => false,
                'noWait'     => false,
                'arguments'  => null,
                'ticket'     => null,
            ],
            $options
        );

        $channel->exchange_declare(
            $name,
            $options['type'],
            $options['passive'],
            $options['durable'],
            $options['autoDelete'],
            $options['internal'],
            $options['noWait'],
            $options['arguments'],
            $options['ticket']
        );

        return $this;
    }
    /**
     * @param AMQPChannel $channel
     * @param string      $queue
     * @param string      $exchange
     * @param string      $routingKey
     *
     * @return $this
     */
    protected function bindQueueToExchange(AMQPChannel $channel, $queue, $exchange, $routingKey = null)
    {
        $channel->queue_bind($queue, $exchange, $routingKey);

        return $this;
    }
    /**
     * @param string $host
     * @param int    $port
     * @param string $user
     * @param string $pass
     * @param string $vhost
     *
     * @return AMQPConnection
     */
    protected function createConnection($host, $port, $user, $pass, $vhost)
    {
        return new AMQPConnection($host, $port, $user, $pass, $vhost);
    }
    /**
     * @return array
     */
    protected function getQueues()
    {
        return [];
    }
    /**
     * @param AMQPChannel $channel
     * @param $messagesToSend
     *
     * @return $this
     */
    protected function sendMessages(AMQPChannel $channel, $messagesToSend)
    {
        if (false === is_array($messagesToSend)) {
            $messagesToSend = [];
        }
        foreach($messagesToSend as $exchange => $messages) {
            foreach($messages as $message) {
                $options = array_merge(
                    [
                        'content_type'     => 'text/json',
                        'content_encoding' => 'utf8',
                        'delivery_mode'    => 2
                    ],
                    true === isset($message['amqp']) ? $message['amqp'] : []
                );
                unset($message['amqp']);
                $routingKey = true === isset($options['routing_key']) ? $options['routing_key'] : null;
                unset($options['routing_key']);
                $m          = new AMQPMessage(json_encode($message), $options);
                $channel->basic_publish($m, $exchange, $routingKey);
            }
        }

        return $this;
    }
    /**
     * @param AMQPChannel $channel
     * @param string      $queue
     * @param \Closure    $callback
     * @param string      $tag
     *
     * @return $this
     */
    protected function addConsumer($channel, $queue, $callback, $tag = null)
    {
        $that = $this;

        $channel->basic_consume($queue, $tag, false, false, false, false, function ($msg) use ($channel, $callback, $that) {
            $data = json_decode($msg->body, true);
            $messagesToSend = call_user_func($callback, $data);
            $that->sendMessages($channel, $messagesToSend);
            /** @var AMQPChannel $_channel */
            $_channel = $msg->delivery_info['channel'];
            $_channel->basic_ack($msg->delivery_info['delivery_tag']);
        });

        return $this;
    }
    /**
     * @param AMQPChannel     $channel
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected abstract function processAmqp(AMQPChannel $channel, InputInterface $input, OutputInterface $output);
    /**
     * @param AMQPConnection $connection
     *
     * @return AMQPChannel
     */
    protected function createChannel(AMQPConnection $connection)
    {
        return $connection->channel();
    }
    /**
     * @return array
     */
    protected function getExchanges()
    {
        return [];
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host  = $input->getOption('amqp-host');
        $port  = $input->getOption('amqp-port');
        $user  = $input->getOption('amqp-user');
        $pass  = $input->getOption('amqp-pass');
        $vhost = $input->getOption('amqp-vhost');

        $connection = $this->createConnection($host, $port, $user, $pass, $vhost);
        $channel    = $this->createChannel($connection);

        foreach($this->getExchanges() as $name => $options) {
            $this->createExchange($channel, $name, $options);
        }

        foreach ($this->getQueues() as $name => $options) {
            $this->createQueue($channel, $name, $options);
        }

        $messages = $this->processAmqp($channel, $input, $output);

        if (true === is_array($messages)) {
            $this->sendMessages($channel, $messages);
        }

        $channel->close();
        $connection->close();
    }
}