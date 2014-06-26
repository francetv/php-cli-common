<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Application;

use Ftven\Build\Common\Command\UpdateCommand;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
class BasicApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $app = new BasicApplication();

        $this->assertEquals('ftven-basic', $app->getName());
    }
    public function testGetForExistingCommandReturnCommand()
    {
        $app = new BasicApplication();

        /** @var UpdateCommand $cmd */
        $cmd = $app->get('update');

        $this->assertEquals('Ftven\\Build\\Common\\Command\\UpdateCommand', get_class($cmd));
        $this->assertEquals('Updates tool to the latest version', $cmd->getDescription());
    }
}