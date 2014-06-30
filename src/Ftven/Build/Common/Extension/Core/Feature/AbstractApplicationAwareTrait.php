<?php

namespace Ftven\Build\Common\Extension\Core\Feature;

use Ftven\Build\Common\Application\Base\AbstractApplication;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait AbstractApplicationAwareTrait
{
    /**
     * @var AbstractApplication
     */
    protected $application;
    /**
     * @param AbstractApplication $application
     *
     * @return $this
     */
    public function setApplication(AbstractApplication $application)
    {
        $this->application = $application;

        return $this;
    }
    /**
     * @return AbstractApplication
     */
    public function getApplication()
    {
        return $this->application;
    }
}