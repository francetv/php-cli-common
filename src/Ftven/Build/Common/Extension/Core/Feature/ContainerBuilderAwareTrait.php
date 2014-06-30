<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Feature;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait ContainerBuilderAwareTrait
{
    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;
    /**
     * @param ContainerBuilder $containerBuilder
     *
     * @return $this
     */
    public function setContainerBuilder($containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;

        return $this;
    }
    /**
     * @return ContainerBuilder
     */
    public function getContainerBuilder()
    {
        return $this->containerBuilder;
    }
}