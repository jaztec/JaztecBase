<?php

namespace JaztecBase\Entity;

abstract class Entity implements EntityInterface
{
    /**
     * Activate all internal setters with the key-value pairs inside an array.
     *
     * @param  array $array
     * @return \JaztecBase\Entity\Entity
     */
    public function updateFromArray(array $array)
    {
        foreach ($array as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method))
                $this->$method($value);
        }
        return $this;
    }

    /**
     * [php-doc]
     */
    public function serialize();
}
