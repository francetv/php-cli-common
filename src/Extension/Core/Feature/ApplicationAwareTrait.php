<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Cli\Extension\Core\Feature;

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
    public function setApplication(Application $application)
    {
        $this->application = $application;

        return $this;
    }
    /**
     * @return Application
     *
     * @throws \RuntimeException
     */
    public function getApplication()
    {
        if (null === $this->application) {
            throw new \RuntimeException('Application not set', 500);
        }

        return $this->application;
    }
}