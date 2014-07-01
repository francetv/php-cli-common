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

use Ftven\Build\Common\Extension\Core\Feature\ServiceAware\FilesystemServiceAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\SymfonyYamlParserAwareTrait;
use Ftven\Build\Common\Extension\Core\Feature\SymfonyYamlAwareTrait;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class YamlService implements YamlServiceInterface
{
    use SymfonyYamlAwareTrait;
    use SymfonyYamlParserAwareTrait;
    use FilesystemServiceAwareTrait;
    /**
     * @param string $path
     *
     * @return array
     */
    public function parseFile($path)
    {
        return $this->parse($this->getFilesystemService()->readFile($path));
    }
    /**
     * @param string $raw
     *
     * @return array
     */
    public function parse($raw)
    {
        return $this->getYamlParser()->parse($raw);
    }
    /**
     * @param array $data
     * @param int   $depth
     *
     * @return string
     */
    public function dump($data, $depth = 20)
    {
        return $this->getYaml()->dump($data, $depth);
    }
}