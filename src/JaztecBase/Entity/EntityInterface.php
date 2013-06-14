<?php

namespace JaztecBase\Entity;

interface EntityInterface
{
    /**
     * Return all the good parts of the entity in an array.
     *
     * @return array
     */
    public function serialize();
}