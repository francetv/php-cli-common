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

use Ftven\Build\Common\Extension\Core\Service\Yaml\YamlServiceInterface;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait YamlServiceAwareTrait
{
    /**
     * @var YamlServiceInterface
     */
    protected $yamlService;
    /**
     * @param YamlServiceInterface $yamlService
     *
     * @return $this
     */
    public function setYamlService($yamlService)
    {
        $this->yamlService = $yamlService;

        return $this;
    }
    /**
     * @return YamlServiceInterface
     */
    public function getYamlService()
    {
        return $this->yamlService;
    }
}