<?php

namespace Ftven\Build\Common\Service;

class GitServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $s = new GitService();

        $this->assertEquals('Ftven\\Build\\Common\\Service\\GitService', get_class($s));
    }
    public function testGetUser()
    {
        $s = new GitService();

        $systemMock = $this->getMock('Ftven\\Build\\Common\\Service\\SystemService', ['execute'], [], '', false);

        $systemMock->expects($this->at(0))->method('execute')
            ->will($this->returnValue(["the@email\n"]))->with('git config --global --get user.email');
        $systemMock->expects($this->at(1))->method('execute')
            ->will($this->returnValue(["the name\n"]))->with('git config --global --get user.name');

        $s->setSystem($systemMock);

        $this->assertEquals(['name' => 'the name', 'email' => 'the@email'], $s->getUser());
    }
}