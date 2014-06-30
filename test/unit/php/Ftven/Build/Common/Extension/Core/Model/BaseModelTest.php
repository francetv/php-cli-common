<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Model;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class BaseModelTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $model = new BaseModel();

        $this->assertEquals('Ftven\\Build\\Common\\Extension\\Core\\Model\\BaseModel', get_class($model));
    }
    public function testConstructWithParametersAddParametersToModel()
    {
        $model1 = new BaseModel(['param1' => 'value1', 'param2' => 'value2']);

        $this->assertArrayHasKey('param1', $model1);
        $this->assertEquals('value1', $model1['param1']);
        $this->assertArrayHasKey('param2', $model1);
        $this->assertEquals('value2', $model1['param2']);

        $model2 = new BaseModel(['param3' => 'value3', 'param4' => 'value4']);

        $this->assertArrayNotHasKey('param1', $model2);
        $this->assertArrayNotHasKey('param2', $model2);
        $this->assertArrayHasKey('param3', $model2);
        $this->assertEquals('value3', $model2['param3']);
        $this->assertArrayHasKey('param4', $model2);
        $this->assertEquals('value4', $model2['param4']);
    }
    public function testConstructWithParametersThatHaveInitMethodDoNotAddParameterToModelButCallInitMethod()
    {
        $model = new BaseModel(['time' => 'this is the value that will be lost']);

        $this->assertArrayHasKey('time', $model);
        $this->assertNotEquals('this is the value that will be lost', $model['time']);
        $this->assertTrue(
            0 < preg_match(
                '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}\T[0-9]{2}\:[0-9]{2}\:[0-9]{2}(Z|[\+\-][0-9]{2}\:[0-9]{2})$/',
                $model['time']
            )
        );
    }
}