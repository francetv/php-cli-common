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