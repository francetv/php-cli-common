<?php

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