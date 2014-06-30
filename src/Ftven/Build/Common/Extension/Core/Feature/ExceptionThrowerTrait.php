<?php

namespace Ftven\Build\Common\Extension\Core\Feature;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
trait ExceptionThrowerTrait
{
    /**
     * @param int    $code
     * @param string $msg
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    protected function throwException($code, $msg)
    {
        $args = func_get_args();

        $code = array_shift($args);

        throw new \RuntimeException(call_user_func_array('sprintf', $args), $code);
    }
}