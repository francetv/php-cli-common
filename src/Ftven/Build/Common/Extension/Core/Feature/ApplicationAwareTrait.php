<?php

namespace Ftven\Build\Common\Extension\Core\Feature;

use Symfony\Component\Console\Application;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait ApplicationAwareTrait
{
    /**
     * @var Application
     */
    protected $application;
    /**
     * @param Application $application
     *
     * @return $this
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }
    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }
}