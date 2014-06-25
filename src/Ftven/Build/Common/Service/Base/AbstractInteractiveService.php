<?php

namespace Ftven\Build\Common\Service\Base;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractInteractiveService extends AbstractService
{
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @var InputInterface
     */
    protected $input;
    /**
     * @param InputInterface $input
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setInput($input)
    {
        if (null === $this->input) {
            throw new \RuntimeException('Input stream not set', 500);
        }

        $this->input = $input;

        return $this;
    }
    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @param OutputInterface $output
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setOutput($output)
    {
        if (null === $this->output) {
            throw new \RuntimeException('Output stream not set', 500);
        }

        $this->output = $output;

        return $this;
    }
    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * @param string $msg
     */
    protected function outln($msg)
    {
        $this->getOutput()->writeln(call_user_func_array('sprintf', func_get_args()));
    }
    /**
     * @param string $msg
     */
    protected function out($msg)
    {
        $this->getOutput()->write(call_user_func_array('sprintf', func_get_args()));
    }
}