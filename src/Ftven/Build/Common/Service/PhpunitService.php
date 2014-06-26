<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Service;

use Ftven\Build\Common\Service\Base\AbstractService;

/**
 * Phpunit Service.
 *
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class PhpunitService extends AbstractService
{
    /**
     * @var SystemService
     */
    protected $system;
    /**
     * @param SystemService $system
     *
     * @return $this
     */
    public function setSystem($system)
    {
        $this->system = $system;

        return $this;
    }
    /**
     * @return SystemService
     */
    public function getSystem()
    {
        return $this->system;
    }
    /**
     * @param null|string $dir
     *
     * @return bool
     */
    public function hasSupport($dir = null)
    {
        try {
            list ($output) = $this->getSystem()->execute('bin/phpunit --version', $dir);

            if (0 < preg_match('/^PHPUnit\s+[0-9]+\.[0-9]+\.[0-9]+/', $output)) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
    /**
     * @param null|string $dir
     *
     * @return $this
     */
    public function test($dir = null)
    {
        $this->getSystem()->execute('bin/phpunit', $dir);

        return $this;
    }
}