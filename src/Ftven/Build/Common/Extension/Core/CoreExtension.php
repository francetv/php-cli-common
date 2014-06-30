<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core;

use Ftven\Build\Common\Extension\Core\Feature\AbstractApplicationAwareTrait;
use Symfony\Component\Console\Command\Command;
use Ftven\Build\Common\ExtensionInterface;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class CoreExtension implements ExtensionInterface
{
    use AbstractApplicationAwareTrait;
    /**
     * @return Command[]
     */
    public function getDefaultCommands()
    {
        return [];
    }
}