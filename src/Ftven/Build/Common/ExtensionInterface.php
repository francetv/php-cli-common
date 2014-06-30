<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common;

use Ftven\Build\Common\Application\Base\AbstractApplication;
use Symfony\Component\Console\Command\Command;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
interface ExtensionInterface
{
    /**
     * @param AbstractApplication $application
     *
     * @return $this
     */
    public function setApplication(AbstractApplication $application);
    /**
     * @return AbstractApplication
     */
    public function getApplication();
    /**
     * @return Command[]
     */
    public function getDefaultCommands();
}