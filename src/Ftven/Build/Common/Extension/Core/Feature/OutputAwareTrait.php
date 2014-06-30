<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Feature;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait OutputAwareTrait
{
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @param OutputInterface $output
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setOutput($output)
    {
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
     *
     * @return $this
     */
    protected function outln($msg)
    {
        $this->getOutput()->writeln(call_user_func_array('sprintf', func_get_args()));

        return $this;
    }
    /**
     * @param string $msg
     *
     * @return $this
     */
    protected function out($msg)
    {
        $this->getOutput()->write(call_user_func_array('sprintf', func_get_args()));

        return $this;
    }
}