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

use Ftven\Build\Common\Extension\Core\Service\System\SystemServiceInterface;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait SystemServiceAwareTrait
{
    /**
     * @var SystemServiceInterface
     */
    protected $systemService;
    /**
     * @param SystemServiceInterface $systemService
     *
     * @return $this
     */
    public function setSystemService($systemService)
    {
        $this->systemService = $systemService;

        return $this;
    }
    /**
     * @return SystemServiceInterface
     */
    public function getSystemService()
    {
        return $this->systemService;
    }
}