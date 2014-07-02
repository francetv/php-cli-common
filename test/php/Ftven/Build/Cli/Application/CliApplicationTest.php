<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Cli\Application;

use Ftven\Build\Cli\Extension\Core\Command\UpdateCommand;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class CliApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $app = new CliApplication();
        $this->assertEquals('UNKNOWN', $app->getName());
        $this->assertEquals('UNKNOWN', $app->getVersion());

        $app2 = new CliApplication('appname');
        $this->assertEquals('appname', $app2->getName());
        $this->assertEquals('UNKNOWN', $app2->getVersion());

        $app2 = new CliApplication('appname2', '1.0.1');
        $this->assertEquals('appname2', $app2->getName());
        $this->assertEquals('1.0.1', $app2->getVersion());
    }
    public function testGetForExistingCommandReturnCommand()
    {
        $app = new CliApplication();

        $this->assertFalse($app->has('update'));

        $app->loadExtensions();
        $app->getContainerBuilder()->compile();

        $this->assertTrue($app->has('update'));

        /** @var UpdateCommand $cmd */
        $cmd = $app->get('update');

        $this->assertEquals('Ftven\\Build\\Cli\\Extension\\Core\\Command\\UpdateCommand', get_class($cmd));
        $this->assertEquals('Updates tool to the latest version', $cmd->getDescription());
    }
    public function testRunHelp()
    {
        $app = new CliApplication();

        $outputMock = $this->getMock('Symfony\\Component\\Console\\Output\\OutputInterface', [], [], '', false);

        $app->setAutoExit(false);

        $this->assertEquals(0, $app->run(null, $outputMock));
    }
}