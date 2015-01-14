<?php

/*
 * This file is part of the CLI COMMON package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Cli\Extension\Core\Base;

use Ftven\Build\Common\Service\Templating\TemplatingServiceInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ftven\Build\Cli\Application\CliApplication;
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
     * @param YamlFileLoader $loader
     *
     * @return $this
     */
    protected function registerYamlConfigFiles(YamlFileLoader $loader)
    {
        unset($loader);

        return $this;
    }
    /**
     * @param XmlFileLoader $loader
     *
     * @return $this
     */
    protected function registerXmlConfigFiles(XmlFileLoader $loader)
    {
        unset($loader);

        return $this;
    }
    /**
     * @param PhpFileLoader $loader
     *
     * @return $this
     */
    protected function registerPhpConfigFiles(PhpFileLoader $loader)
    {
        unset($loader);

        return $this;
    }
    /**
     * @param ContainerBuilder $container
     * @param array            $config
     *
     * @return $this
     */
    protected function registerCustom(ContainerBuilder $container, array $config)
    {
        unset($container);
        unset($config);

        return $this;
    }
    /**
     * @param TemplatingServiceInterface $templateService
     *
     * @return $this
     */
    protected function registerTemplates(TemplatingServiceInterface $templateService)
    {
        unset($templateService);

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

        $yamlLoader = new YamlFileLoader(
            $container,
            new FileLocator(dirname($rClass->getFileName()) . '/Resources/config')
        );

        $xmlLoader = new XmlFileLoader(
            $container,
            new FileLocator(dirname($rClass->getFileName()) . '/Resources/config')
        );

        $phpLoader = new PhpFileLoader(
            $container,
            new FileLocator(dirname($rClass->getFileName()) . '/Resources/config')
        );

        $this->registerCustom($container, $config);
        $this->registerConfigFiles($yamlLoader);
        $this->registerYamlConfigFiles($yamlLoader);
        $this->registerXmlConfigFiles($xmlLoader);
        $this->registerPhpConfigFiles($phpLoader);
        $this->registerCompilerPasses($container);

        /** @var CliApplication $application */
        $application = $container->get('application');

        $this->registerCommands($application);

        /** @var TemplatingServiceInterface $templatingService */
        $templatingService = $container->get('common.services.templating');
        $this->registerTemplates($templatingService);
    }
}