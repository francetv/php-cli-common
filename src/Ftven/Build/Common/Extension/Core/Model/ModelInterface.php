<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Model;

use ArrayAccess;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
interface ModelInterface extends ArrayAccess
{
    /**
     * @param array $data
     */
    public function __construct($data = []);
    /**
     * @return array
     */
    public function toArray();
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getKey($key);
}