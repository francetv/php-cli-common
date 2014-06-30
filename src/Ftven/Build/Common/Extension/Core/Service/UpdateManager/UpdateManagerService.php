<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\UpdateManager;

use Ftven\Build\Common\Extension\Core\Feature\StringFormatterTrait;
use Herrera\Phar\Update\Manifest;
use Herrera\Phar\Update\Manager;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class UpdateManagerService implements UpdateManagerServiceInterface
{
    use StringFormatterTrait;
    /**
     * @var string
     */
    protected $managerClass;
    /**
     * @param string $managerClass
     *
     * @return $this
     */
    public function setManagerClass($managerClass)
    {
        $this->managerClass = $managerClass;

        return $this;
    }
    /**
     * @return string
     */
    public function getManagerClass()
    {
        return $this->managerClass;
    }
    /**
     * @param string $version
     * @param string $manifestFile
     *
     * @return $this
     */
    public function update($version, $manifestFile)
    {
        $managerClass = $this->getManagerClass();

        /** @var Manager $manager */
        $manager = new $managerClass(Manifest::loadFile($manifestFile));

        $manager->update($version, true);

        return $this;
    }
}