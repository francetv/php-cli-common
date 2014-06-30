<?php

namespace Ftven\Build\Common\Extension\Core\Feature;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait SluggerTrait
{
    /**
     * @param string $text
     * @param string $separator
     *
     * @return string
     */
    protected function slug($text, $separator = '-')
    {
        return preg_replace('/[^a-z0-9_\-\.]+/', $separator, strtolower($text));
    }
}