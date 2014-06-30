<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\System;

use RuntimeException;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
interface SystemServiceInterface
{
    /**
     * @param string $command
     * @param string $dir
     * @param array  $goodExitCodes
     *
     * @return array
     *
     * @throws RuntimeException
     */
    public function execute($command, $dir = null, $goodExitCodes = [0]);
}