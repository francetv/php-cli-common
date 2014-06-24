<?php

namespace Ftven\Build\Common\Service;

use Ftven\Build\Common\Service\Base\AbstractService;

class GitService extends AbstractService
{
    /**
     * @param string $key
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function getConfigValue($key)
    {
        $output = [];
        $return = 0;

        $value = exec(sprintf('git config --global --get %s', $key), $output, $return);

        if (0 < $return) {
            throw new \RuntimeException(sprintf("Unable to retrieve Git %s", str_replace('.', ' ', $key)), 60);
        }

        return trim($value);
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