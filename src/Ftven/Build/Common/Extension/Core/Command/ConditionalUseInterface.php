<?php

namespace Ftven\Build\Common\Extension\Core\Command;

interface ConditionalUseInterface
{
    /**
     * @return bool
     */
    public function isUsable();
}