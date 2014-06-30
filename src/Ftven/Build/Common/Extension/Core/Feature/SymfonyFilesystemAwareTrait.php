<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Feature;

use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait SymfonyFilesystemAwareTrait
{
    /**
     * @var Filesystem
     */
    protected $filesystem;
    /**
     * @param Filesystem $filesystem
     *
     * @return $this
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }
    /**
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }
}