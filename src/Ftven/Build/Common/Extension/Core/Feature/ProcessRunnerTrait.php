<?php

namespace Ftven\Build\Common\Extension\Core\Feature;

use Symfony\Component\Process\Process;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait ProcessRunnerTrait
{
    /**
     * @param string      $command
     * @param null|string $workingDirectory
     *
     * @return Process
     */
    protected function createProcess($command, $workingDirectory = null)
    {
        return new Process($command, $workingDirectory);
    }
}