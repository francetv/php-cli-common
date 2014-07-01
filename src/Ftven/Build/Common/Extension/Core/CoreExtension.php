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

use Ftven\Build\Common\Extension\Core\DependencyInjection\CompilerPass\AutomaticCommandRegistrationCompilerPass;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Ftven\Build\Common\Extension\Core\Base\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class CoreExtension extends AbstractExtension
{
    /**
     * @param YamlFileLoader $loader
     *
     * @return $this|void
     */
    protected function registerConfigFiles(YamlFileLoader $loader)
    {
        $loader->load('services.yml');
    }
    /**
     * @param ContainerBuilder $container
     *
     * @return $this|void
     */
    protected function registerCompilerPasses(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AutomaticCommandRegistrationCompilerPass());
    }
}