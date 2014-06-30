<?php

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