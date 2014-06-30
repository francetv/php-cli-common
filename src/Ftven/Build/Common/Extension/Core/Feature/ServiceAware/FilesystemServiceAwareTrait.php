<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Feature\ServiceAware;

use Ftven\Build\Common\Extension\Core\Service\Filesystem\FilesystemServiceInterface;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
trait FilesystemServiceAwareTrait
{
    /**
     * @var FilesystemServiceInterface
     */
    protected $filesystemService;
    /**
     * @param FilesystemServiceInterface $filesystemService
     *
     * @return $this
     */
    public function setFilesystemService($filesystemService)
    {
        $this->filesystemService = $filesystemService;

        return $this;
    }
    /**
     * @return FilesystemServiceInterface
     */
    public function getFilesystemService()
    {
        return $this->filesystemService;
    }
}