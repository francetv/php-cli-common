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
    /**
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return mixed
     */
    protected function arg($name, $defaultValue = null)
    {
        $value = $this->getInput()->getArgument($name);

        if (null === $value) {
            return $defaultValue;
        }

        return $value;
    }
    /**
     * @param string $name
     *
     * @return bool
     */
    protected function hasArg($name)
    {
        return null !== $this->getInput()->getArgument($name);
    }
    /**
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return mixed|null
     */
    protected function option($name, $defaultValue = null)
    {
        $value = $this->getInput()->getOption($name);

        if (null === $value) {
            return $defaultValue;
        }

        return $value;
    }
    /**
     * @param string $name
     *
     * @return bool
     */
    protected function hasOption($name)
    {
        return null !== $this->getInput()->getOption($name);
    }
}