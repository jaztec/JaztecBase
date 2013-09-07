<?php

namespace JaztecBase\Entity;

abstract class AbstractEntity implements EntityInterface
{
    /**
     * [php-doc]
     */
    public function fromArray(array $array)
    {
        foreach ($array as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * [php-doc]
     */
    abstract public function toArray();
}
