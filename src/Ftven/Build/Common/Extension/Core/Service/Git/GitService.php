<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\Git;

use Ftven\Build\Common\Extension\Core\Feature\ServiceAware\SystemServiceAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\StringFormatterTrait;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class GitService implements GitServiceInterface
{
    use StringFormatterTrait;
    use SystemServiceAwareTrait;
    /**
     * @param string $key
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function getConfigValue($key)
    {
        list($output) = $this->getSystemService()->execute($this->_('git config --global --get %s', $key));

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