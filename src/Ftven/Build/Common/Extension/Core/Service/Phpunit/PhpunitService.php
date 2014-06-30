<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\Phpunit;

use Ftven\Build\Common\Extension\Core\Feature\ServiceAware\SystemServiceAwareTrait;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class PhpunitService implements PhpunitServiceInterface
{
    use SystemServiceAwareTrait;
    /**
     * @param null|string $dir
     *
     * @return bool
     */
    public function hasSupport($dir = null)
    {
        try {
            list ($output) = $this->getSystemService()->execute('bin/phpunit --version', $dir);

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
        $this->getSystemService()->execute('bin/phpunit', $dir);

        return $this;
    }
}