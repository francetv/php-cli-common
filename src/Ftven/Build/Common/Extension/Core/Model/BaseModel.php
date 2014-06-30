<?php

/*
 * This file is part of the Cli-common package.
 *
 * (c) France Télévisions Editions Numériques <guillaume.postaire@francetv.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ftven\Build\Common\Extension\Core\Model;

/**
 * @author Olivier Hoareau <olivier@phppro.fr>
 */
class BaseModel implements ModelInterface
{
    /**
     * @var string
     */
    protected $time;
    /**
     * @param array $data
     */
    public function __construct($data = [])
    {
        $rClass = new \ReflectionClass($this);

        foreach($rClass->getMethods() as $rMethod) {
            if ('init' !== substr($rMethod->getName(), 0, strlen('init'))) {
                continue;
            }
            $this->{$rMethod->getName()}($data);
        }

        foreach($data as $k => $v) {
            if (true === method_exists($this, 'init' . ucfirst($k))) {
                continue;
            }
            $this->offsetSet($k, $v);
        }
    }
    /**
     * @param array $a
     * @param array $b
     *
     * @return array
     */
    protected function merge($a, $b)
    {
        if (!is_array($a)) {
            if (!is_array($b)) return [];
            return $b;
        }

        if (!is_array($b)) return $a;

        foreach($b as $k => $v) {
            if (!isset($a[$k])) {
                $a[$k] = $v;
                continue;
            }
            if (!is_array($v)) {
                if (!is_array($a[$k])) {
                    $a[$k] = $v;
                    continue;
                }
                $a[$k] = array_merge($a[$k], [$v]);
                foreach(array_keys($a[$k]) as $kk) {
                    if (is_numeric($kk)) {
                        $a[$k] = array_unique($a[$k]);
                        break;
                    }
                }
                continue;
            }
            $a[$k] = array_merge($a[$k], $b[$k]);
            foreach(array_keys($a[$k]) as $kk) {
                if (is_numeric($kk)) {
                    $a[$k] = array_unique($a[$k]);
                    break;
                }
            }
        }

        return $a;
    }
    /**
     * @param array  $array
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    protected function val($array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return true === method_exists($this, 'get' . ucfirst($offset)) || true === isset($this->$offset);
    }
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if (false === method_exists($this, 'get' . ucfirst($offset))) {
            if (true === isset($this->$offset)) {
                return $this->$offset;
            }

            return null;
        }

        return $this->{'get' . ucfirst($offset)}();
    }
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return $this
     */
    public function offsetSet($offset, $value)
    {
        if (false === method_exists($this, 'set' . ucfirst($offset))) {
            $this->$offset = $value;

            return $this;
        }

        return $this->{'set' . ucfirst($offset)}($value);
    }
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return $this
     */
    public function offsetUnset($offset)
    {
        if (false === method_exists($this, 'set' . ucfirst($offset))) {
            unset($this->$offset);

            return $this;
        }

        return $this->offsetSet($offset, null);
    }
    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];

        foreach($this as $k => $v) {
            $data[$k] = $v;
        }

        return $data;
    }
    /**
     * @param string $type
     * @param string $id
     *
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function getTypeById($type, $id)
    {
        $items = isset($this->$type) ? $this->$type : [];

        if (false === isset($items[$id])) {
            throw new \RuntimeException(sprintf("Unknown %s item with id '%s'", $type, $id), 404);
        }

        return $items[$id];
    }
    /**
     * @param string $type
     * @param string $property
     * @param mixed  $value
     *
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function getTypeByProperty($type, $property, $value)
    {
        foreach($this->{'get' . ucfirst($type)}() as $item) {
            if (true === isset($item[$property]) && $value === $item[$property]) {
                return $item;
            }
        }

        throw new \RuntimeException(sprintf("Unknown %s item with %s '%s'", $type, $property, $value), 404);
    }
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getKey($key)
    {
        $tokens = explode('.', $key);


        $first = array_shift($tokens);
        $first = str_replace('POINT', '.', $first);

        $that = $this;

        $value = $that[$first];

        foreach($tokens as $k) {
            $k = str_replace('POINT', '.', $k);
            if (false === isset($value[$k])) {
                return null;
            }
            $value = $value[$k];
        }

        return $value;
    }
    /**
     * @return $this
     */
    public function initTime()
    {
        $this->time = date('c', microtime(true));

        return $this;
    }
}