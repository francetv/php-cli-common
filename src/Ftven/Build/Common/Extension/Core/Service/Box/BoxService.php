<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\Box;

use Ftven\Build\Common\Extension\Core\Feature\ServiceAware\PhpunitServiceAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\ServiceAware\SystemServiceAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\StringFormatterTrait;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class BoxService implements BoxServiceInterface
{
    use StringFormatterTrait;
    use SystemServiceAwareTrait;
    use PhpunitServiceAwareTrait;
    /**
     * @param null|string $dir
     * @param null|string $copyTo
     *
     * @return string
     *
     * @todo do not use directly json_decode()
     * @todo do not use directly file_get_contents()
     */
    public function package($dir = null, $copyTo = null)
    {
        if (true === $this->getPhpunitService()->hasSupport()) {
            $this->getPhpunitService()->test($dir);
        }

        $this->getSystemService()->execute('bin/box build', $dir);

        $box = @json_decode(file_get_contents('box.json'), true);
        $file = $box['output'];

        if (null === $copyTo) {
            return $file;
        }

        $this->getSystemService()->execute($this->_('sudo cp %s %s', $file, $copyTo));

        return $file;
    }
}