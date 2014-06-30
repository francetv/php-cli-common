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

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait EnvironmentAwareTrait
{
    /**
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return null|string
     */
    protected function env($name, $defaultValue = null)
    {
        $value = getenv($name);

        if (null === $value || false === $value) {
            return $defaultValue;
        }

        return $value;
    }
}