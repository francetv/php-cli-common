<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\System;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class SystemServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $s = new SystemService();

        $this->assertEquals('Ftven\\Build\\Common\\Extension\\Core\\Service\\System\\SystemService', get_class($s));
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
    /**
     * @group integration-test
     */
    public function testExecuteForFailingCommandWithExpectedExitCodesDoNotThrowException()
    {
        $s = new SystemService();

        list($output, $errorOutput, $return) = $s->execute('echo thetexthere ; exit 2', null, [0, 2]);

        $this->assertEquals('thetexthere' . PHP_EOL, $output);
        $this->assertEquals('', $errorOutput);
        $this->assertEquals(2, $return);
    }
}