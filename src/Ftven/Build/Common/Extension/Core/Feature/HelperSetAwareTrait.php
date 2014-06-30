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

use Symfony\Component\Console\Helper\HelperSet;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait HelperSetAwareTrait
{
    /**
     * @var HelperSet
     */
    protected $helperSet;
    /**
     * @param HelperSet $helperSet
     *
     * @return $this
     */
    public function setHelperSet($helperSet)
    {
        $this->helperSet = $helperSet;

        return $this;
    }
    /**
     * @return HelperSet
     */
    public function getHelperSet()
    {
        return $this->helperSet;
    }
}