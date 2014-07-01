<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Service\Yaml;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
interface YamlServiceInterface
{
    /**
     * @param Yaml $yaml
     *
     * @return $this
     */
    public function setYaml(Yaml $yaml);
    /**
     * @param Parser $yamlParser
     *
     * @return $this
     */
    public function setYamlParser(Parser $yamlParser);
    /**
     * @return Yaml
     */
    public function getYaml();
    /**
     * @return Parser
     */
    public function getYamlParser();
    /**
     * @param string $path
     *
     * @return array
     */
    public function parseFile($path);
    /**
     * @param string $raw
     *
     * @return array
     */
    public function parse($raw);
    /**
     * @param array $data
     * @param int   $depth
     *
     * @return string
     */
    public function dump($data, $depth = 20);
}