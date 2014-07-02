<?php

namespace Ftven\Build\Cli\Extension\Core\Command;

interface ConditionalUseInterface
{
    /**
     * @return bool
     */
    public function isUsable();
}