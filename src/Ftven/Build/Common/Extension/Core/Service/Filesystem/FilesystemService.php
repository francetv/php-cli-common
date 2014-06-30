<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\Filesystem;

use Ftven\Build\Common\Extension\Core\Feature\SymfonyFilesystemAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\ExceptionThrowerTrait;
use RuntimeException;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class FilesystemService implements FilesystemServiceInterface
{
    use ExceptionThrowerTrait;
    use SymfonyFilesystemAwareTrait;
    /**
     * @param string $path
     * @param int    $mode
     *
     * @return $this
     *
     * @throws RuntimeException
     */
    public function createDirectory($path, $mode = 0777)
    {
        $this->getFilesystem()->mkdir($path, $mode);

        return $this;
    }
    /**
     * @param string $path
     *
     * @return string
     *
     * @throws RuntimeException
     *
     * @todo do not use directly file_get_contents()
     */
    public function readFile($path)
    {
        file_get_contents($path);

        return $this;
    }
    /**
     * @param string $path
     * @param string $content
     * @param int    $mode
     *
     * @return $this
     *
     * @throws RuntimeException
     */
    public function writeFile($path, $content, $mode = 0666)
    {
        $this->getFilesystem()->dumpFile($path, $content, $mode);

        return $this;
    }
}