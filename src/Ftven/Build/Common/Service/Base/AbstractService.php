<?php

namespace Ftven\Build\Common\Service\Base;

use Ftven\Build\Common\ServiceInterface;

abstract class AbstractService implements ServiceInterface
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