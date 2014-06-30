<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Feature\ServiceAware;

use Ftven\Build\Common\Extension\Core\Service\Phpunit\PhpunitServiceInterface;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait PhpunitServiceAwareTrait
{
    /**
     * @var PhpunitServiceInterface
     */
    protected $phpunitService;
    /**
     * @param PhpunitServiceInterface $phpunitService
     *
     * @return $this
     */
    public function setPhpunitService($phpunitService)
    {
        $this->phpunitService = $phpunitService;

        return $this;
    }
    /**
     * @return PhpunitServiceInterface
     */
    public function getPhpunitService()
    {
        return $this->phpunitService;
    }
}