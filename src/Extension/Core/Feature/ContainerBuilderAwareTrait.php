<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Cli\Extension\Core\Feature;

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
    public function setContainerBuilder(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;

        return $this;
    }
    /**
     * @return ContainerBuilder
     *
     * @throws \RuntimeException
     */
    public function getContainerBuilder()
    {
        if (null === $this->containerBuilder) {
            throw new \RuntimeException('Container Builder not set', 500);
        }

        return $this->containerBuilder;
    }
}