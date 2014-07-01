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

use Symfony\Component\Yaml\Yaml;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait SymfonyYamlAwareTrait
{
    /**
     * @var Yaml
     */
    protected $yaml;
    /**
     * @param Yaml $yaml
     *
     * @return $this
     */
    public function setYaml(Yaml $yaml)
    {
        $this->yaml = $yaml;

        return $this;
    }
    /**
     * @return Yaml
     */
    public function getYaml()
    {
        return $this->yaml;
    }
}