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

use Ftven\Build\Common\Service\Base\AbstractInteractiveService;

/**
 * Box Service.
 *
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class BoxService extends AbstractInteractiveService
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
     * @param null|string $copyTo
     *
     * @return string
     */
    public function build($dir = null, $copyTo = null)
    {
        $this->getSystem()->execute('bin/box build', $dir);

        $box = @json_decode(file_get_contents('box.json'), true);
        $file = $box['output'];

        if (null === $copyTo) {
            return $file;
        }

        $this->getSystem()->execute($this->_('sudo cp %s %s', $file, $copyTo));

        return $file;
    }
}