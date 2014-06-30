<?php

namespace Ftven\Build\Common\Extension\Core\Feature;

use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
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