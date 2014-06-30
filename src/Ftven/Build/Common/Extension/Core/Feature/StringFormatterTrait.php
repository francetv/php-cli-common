<?php

namespace Ftven\Build\Common\Extension\Core\Feature;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
trait StringFormatterTrait
{
    /**
     * @param string $msg
     *
     * @return string
     */
    protected function _($msg)
    {
        return call_user_func_array('sprintf', func_get_args());
    }
}