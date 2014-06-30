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

use Ftven\Build\Common\Extension\Core\Service\Box\BoxServiceInterface;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait BoxServiceAwareTrait
{
    /**
     * @var BoxServiceInterface
     */
    protected $boxService;
    /**
     * @param BoxServiceInterface $boxService
     *
     * @return $this
     */
    public function setBoxService($boxService)
    {
        $this->boxService = $boxService;

        return $this;
    }
    /**
     * @return BoxServiceInterface
     */
    public function getBoxService()
    {
        return $this->boxService;
    }
}