<?php

namespace Ftven\Build\Common\Service;

class SystemServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $s = new SystemService();

        $this->assertEquals('Ftven\\Build\\Common\\Service\\SystemService', get_class($s));
    }
    /**
     * @group integration-test
     */
    public function testExecuteForFailingCommandThrowException()
    {
        $s = new SystemService();

        $this->setExpectedException('RuntimeException', 'Error when executing [exit 1]', 1);

        $s->execute('exit 1');
    }
}