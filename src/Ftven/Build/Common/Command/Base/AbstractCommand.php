<?php

namespace Ftven\Build\Common\Command\Base;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        if (!ini_get('date.timezone')) {
            ini_set('date.timezone', 'Europe/Paris');
        }

    }
    /**
     * @return string
     */
    public function getType()
    {
        return strtolower(join(
            '-',
            array_values(
                array_reverse(
                    explode('/',
                        preg_replace(
                            ',^Ftven/Build/[^/]+/Command/,',
                            '',
                            str_replace(
                                '\\',
                                '/',
                                preg_replace(
                                    '/Command$/',
                                    '',
                                    get_class($this)
                                )
                            )
                        )
                    )
                )
            )
        ));
    }
}