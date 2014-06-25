<?php

namespace Ftven\Build\Common\Service;

use Ftven\Build\Common\Service\Base\AbstractInteractiveService;

class BoxService extends AbstractInteractiveService
{
    /**
     * @var SystemService
     */
    protected $system;
    /**
     * @param SystemService $system
     *
     * @return $this
     */
    public function setSystem($system)
    {
        $this->system = $system;

        return $this;
    }
    /**
     * @return SystemService
     */
    public function getSystem()
    {
        return $this->system;
    }
    /**
     * @param null|string $dir
     * @param null|string $copyTo
     *
     * @return string
     */
    public function build($dir = null, $copyTo = null)
    {
        $this->getSystem()->execute('bin/box build', $dir);

        $box = @json_decode(file_get_contents('box.json'), true);
        $file = $box['output'];

        if (null === $copyTo) {
            return $file;
        }

        $this->getSystem()->execute($this->_('sudo cp %s %s', $file, $copyTo));

        return $file;
    }
}