<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\Box;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class BoxServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $s = new BoxService();

        $this->assertEquals('Ftven\\Build\\Common\\Extension\\Core\\Service\\Box\\BoxService', get_class($s));
    }
}