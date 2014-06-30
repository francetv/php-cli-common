<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Application;

use Ftven\Build\Common\Extension\Core\Feature\ContainerBuilderAwareTrait;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Console\Output\OutputInterface;
use Ftven\Build\Common\Extension\Core\CoreExtension;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class CliApplication extends Application
{
    use ContainerBuilderAwareTrait;
    /**
     * @var ExtensionInterface[]
     */
    protected $extensions;
    /**
     * @var array
     */
    protected $config;
    /**
     * @param string $name    The name of the application
     * @param string $version The version of the application
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);


        $this->setContainerBuilder(new ContainerBuilder());

        $this->extensions = [];
        $this->config     = new \ArrayObject();

        $this->addExtension(new CoreExtension());
    }
    /**
     * @return ExtensionInterface[]
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
    /**
     * @param ExtensionInterface $extension
     *
     * @return $this
     */
    public function addExtension(ExtensionInterface $extension)
    {
        $this->extensions[] = $extension;

        return $this;
    }
    /**
     * @return $this
     */
    public function loadExtensions()
    {
        $container = $this->getContainerBuilder();
        $container->set('application', $this);

        foreach($this->getExtensions() as $extension) {
            $extension->load((array)$this->config, $container);
        }

        return $this;
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|mixed
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->loadExtensions();

        return parent::run($input, $output);
    }
}