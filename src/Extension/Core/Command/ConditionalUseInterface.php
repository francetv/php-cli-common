<?php

/*
 * This file is part of the CLI COMMON package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Cli\Extension\Core\Command;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
interface ConditionalUseInterface
{
    /**
     * @return bool
     */
    public function isUsable();
}