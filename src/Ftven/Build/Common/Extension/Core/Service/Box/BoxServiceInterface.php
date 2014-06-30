<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\Box;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
interface BoxServiceInterface
{
    /**
     * @param null|string $dir
     * @param null|string $copyTo
     *
     * @return string
     */
    public function package($dir = null, $copyTo = null);
}