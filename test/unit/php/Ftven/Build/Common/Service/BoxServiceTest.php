<?php

namespace Ftven\Build\Common\Service;

class BoxServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $s = new BoxService();

        $this->assertEquals('Ftven\\Build\\Common\\Service\\BoxService', get_class($s));
    }
}