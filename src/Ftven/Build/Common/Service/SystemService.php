<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Service;

use Ftven\Build\Common\Service\Base\AbstractInteractiveService;
use Symfony\Component\Process\Process;

/**
 * System Service.
 *
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class SystemService extends AbstractInteractiveService
{
    /**
     * @param string $command
     * @param string $dir
     * @param array  $goodExitCodes
     *
     * @return array
     *
     * @throws \RuntimeException
     */
    public function execute($command, $dir = null, $goodExitCodes = [0])
    {
        $cmd = new Process($command, $dir);

        $return = $cmd->run();

        if (null === $goodExitCodes || true === in_array($return, $goodExitCodes)) {
            return [$cmd->getOutput(), $cmd->getErrorOutput(), $return, $cmd->getExitCodeText()];
        }

        throw new \RuntimeException(
            $this->_("Error when executing [%s]: %s", $cmd->getCommandLine(), $cmd->getErrorOutput()),
            $return
        );
    }
}