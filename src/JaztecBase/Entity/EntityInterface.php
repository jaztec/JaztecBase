<?php

namespace JaztecBase\Entity;

interface Entity
{
    /**
     * Return all the good parts of the entity in an array.
     *
     * @return array
     */
    public function serialize();
}