<?php

namespace Ftven\Build\Common\Extension\Core\Feature;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait ContainerAwareTrait
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @param ContainerInterface $container
     *
     * @return $this
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }
    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}