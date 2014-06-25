<?php

namespace Ftven\Build\Common\Application;

use Ftven\Build\Common\Command\UpdateCommand;

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