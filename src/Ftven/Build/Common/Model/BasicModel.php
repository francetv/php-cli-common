<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Model;

use Ftven\Build\Common\Model\Base\AbstractModel;

/**
 * Basic Model, do not use directly, for testing purpose.
 *
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class BasicModel extends AbstractModel
{
    /**
     * @return $this
     */
    public function initTime()
    {
        $this->time = date('c', microtime(true));

        return $this;
    }
}