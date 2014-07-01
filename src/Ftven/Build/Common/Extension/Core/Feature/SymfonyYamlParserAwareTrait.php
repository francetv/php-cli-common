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

use Symfony\Component\Yaml\Parser;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait SymfonyYamlParserAwareTrait
{
    /**
     * @var Parser
     */
    protected $yamlParser;
    /**
     * @param Parser $yamlParser
     *
     * @return $this
     */
    public function setYamlParser(Parser $yamlParser)
    {
        $this->yamlParser = $yamlParser;

        return $this;
    }
    /**
     * @return Parser
     */
    public function getYamlParser()
    {
        return $this->yamlParser;
    }
}