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

use Ftven\Build\Common\Extension\Core\Service\Git\GitServiceInterface;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait GitServiceAwareTrait
{
    /**
     * @var GitServiceInterface
     */
    protected $gitService;
    /**
     * @param GitServiceInterface $gitService
     *
     * @return $this
     */
    public function setGitService($gitService)
    {
        $this->gitService = $gitService;

        return $this;
    }
    /**
     * @return GitServiceInterface
     */
    public function getGitService()
    {
        return $this->gitService;
    }
}