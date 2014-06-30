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

use Ftven\Build\Common\Extension\Core\Service\UpdateManager\UpdateManagerServiceInterface;

/**
 * @author Olivier Hoareau olivier@phppro.fr>
 */
trait UpdateManagerServiceAwareTrait
{
    /**
     * @var UpdateManagerServiceInterface
     */
    protected $updateManagerService;
    /**
     * @param UpdateManagerServiceInterface $updateManagerService
     *
     * @return $this
     */
    public function setUpdateManagerService($updateManagerService)
    {
        $this->updateManagerService = $updateManagerService;

        return $this;
    }
    /**
     * @return UpdateManagerServiceInterface
     */
    public function getUpdateManagerService()
    {
        return $this->updateManagerService;
    }
}