<?php

namespace Ftven\Build\Common\Service;

use Ftven\Build\Common\Service\Base\AbstractInteractiveService;
use Symfony\Component\Process\Process;

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

        if (null === $goodExitCodes) {
            return [$cmd->getOutput(), $cmd->getErrorOutput(), $return, $cmd->getExitCodeText()];
        }

        if (false === in_array($return, $goodExitCodes)) {
            throw new \RuntimeException(
                $this->_("Error when executing [%s]: %s", $cmd->getCommandLine(), $cmd->getErrorOutput()),
                $return
            );
        }
    }
}