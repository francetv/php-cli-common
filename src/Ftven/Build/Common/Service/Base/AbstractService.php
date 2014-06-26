<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Service\Base;

use Ftven\Build\Common\ServiceInterface;

/**
 * Abstract Service.
 *
 * @author Olivier Hoareau olivier@phppro.fr>
 */
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