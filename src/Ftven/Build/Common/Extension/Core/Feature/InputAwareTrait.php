<?php

namespace Ftven\Build\Common\Extension\Core\Feature;

use Symfony\Component\Console\Input\InputInterface;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
trait InputAwareTrait
{
    /**
     * @var InputInterface
     */
    protected $input;
    /**
     * @param InputInterface $input
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }
    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }
}