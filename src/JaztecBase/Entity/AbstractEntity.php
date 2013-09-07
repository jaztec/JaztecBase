<?php

namespace JaztecBase\Entity;

abstract class AbstractEntity implements EntityInterface
{
    /**
     * Activate all internal setters with the key-value pairs inside an array.
     *
     * @param array $array
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
