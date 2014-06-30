<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Application;
use Symfony\Component\Config\FileLocator;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class CoreExtension extends Extension
{
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
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Resources/config'));
        $loader->load('services.yml');

        /** @var Application $application */
        $application = $container->get('application');

        $commands = [
            $container->get('common.commands.update'),
        ];

        if (true === $this->hasBoxSupport($container)) {
            $commands[] = $container->get('common.commands.package');
        }

        foreach($container->getDefinitions() as $id => $definition) {
            if (0 >= preg_match('/\.commands\./', $id)) {
                continue;
            }
            $commands[] = $container->get($id);
        }

        $application->addCommands($commands);
    }
    /**
     * @param ContainerBuilder $container
     *
     * @return bool
     */
    protected function hasBoxSupport(ContainerBuilder $container)
    {
        /** @var Filesystem $fs */
        $fs = $container->get('common.services.filesystem');

        return $fs->exists('box.json') && $fs->exists('bin/box');
    }
}