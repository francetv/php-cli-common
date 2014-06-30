<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Command;

use Ftven\Build\Common\Extension\Core\Feature\ServiceAware\BoxServiceAwareTrait;
use Ftven\Build\Common\Command\Base\AbstractCommand;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class PackageCommand extends AbstractCommand
{
    use BoxServiceAwareTrait;
    /**
     * @return array
     */
    protected function describe()
    {
        return [
            'name'        => 'package',
            'description' => 'Packages the tool to a phar',
            'options'     => [
                'install' => [
                    'optional'    => true,
                    'description' => 'Optionnally install the newly created phar into the system directory',
                ]
            ]
        ];
    }
    /**
     * @return int|void
     *
     * @throws \RuntimeException
     * @throws \Exception
     */
    protected function process()
    {
        $copyTo = null;

        if (null !== $this->option('install')) {
            $copyTo = $this->_('/usr/local/bin/%name%', $this->getApplication()->getType());
            if (true === is_string($this->option('install'))) {
                $copyTo = $this->option('install');
            }
        }

        $this->getBoxService()->package(null, $copyTo);
    }
}