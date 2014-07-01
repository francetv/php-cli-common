<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Base;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ftven\Build\Common\Application\CliApplication;
use Symfony\Component\Config\FileLocator;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
abstract class AbstractExtension extends Extension
{
    /**
     * @param ContainerBuilder $container
     *
     * @return $this
     */
    protected function registerCompilerPasses(ContainerBuilder $container)
    {
        unset($container);

        return $this;
    }
    /**
     * @param CliApplication $application
     *
     * @return $this
     */
    protected function registerCommands(CliApplication $application)
    {
        unset($application);

        return $this;
    }
    /**
     * @param YamlFileLoader $loader
     *
     * @return $this
     */
    protected function registerConfigFiles(YamlFileLoader $loader)
    {
        unset($loader);

        return $this;
    }
    /**
     * Loads a specific configuration.
     *
     * @param array $config An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $rClass = new \ReflectionClass($this);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(dirname($rClass->getFileName()) . '/Resources/config')
        );

        $this->registerConfigFiles($loader);
        $this->registerCompilerPasses($container);

        /** @var CliApplication $application */
        $application = $container->get('application');

        $this->registerCommands($application);
    }
}