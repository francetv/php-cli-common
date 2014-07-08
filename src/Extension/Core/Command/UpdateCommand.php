<?php

/*
 * This file is part of the CLI COMMON package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Cli\Extension\Core\Command;

use Ftven\Build\Common\Feature\ServiceAware\UpdateManagerServiceAwareTrait;
use Ftven\Build\Cli\Extension\Core\Command\Base\AbstractCommand;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class UpdateCommand extends AbstractCommand
{
    use UpdateManagerServiceAwareTrait;
    /**
     * @var string
     */
    protected $manifestFilePattern;
    /**
     * @param string $manifestFilePattern
     */
    public function __construct($manifestFilePattern)
    {
        $this->manifestFilePattern = $manifestFilePattern;

        parent::__construct();
    }
    /**
     * @return array
     */
    protected function describe()
    {
        return [
            'name'        => 'update',
            'description' => 'Updates tool to the latest version',
        ];
    }
    /**
     * @return int|void
     */
    protected function process()
    {
        $this->getUpdateManagerService()->update(
            $this->getApplication()->getVersion(),
            str_replace('{name}', $this->getApplication()->getName(), $this->manifestFilePattern)
        );
    }
}