<?php

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