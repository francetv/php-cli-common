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
 * Git Service.
 *
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class GitService extends AbstractService
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
     * @param string $key
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function getConfigValue($key)
    {
        list($output) = $this->getSystem()->execute($this->_('git config --global --get %s', $key));

        return trim($output);
    }
    /**
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getUserEmail()
    {
        return $this->getConfigValue('user.email');
    }
    /**
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getUserName()
    {
        return $this->getConfigValue('user.name');
    }
    /**
     * @return array
     */
    public function getUser()
    {
        return [
            'email' => $this->getUserEmail(),
            'name'  => $this->getUserName(),
        ];
    }
}