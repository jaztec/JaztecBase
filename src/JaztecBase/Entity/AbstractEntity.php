<?php

namespace JaztecBase\Entity;

abstract class AbstractEntity implements EntityInterface
{
    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    abstract public function toArray();
}
