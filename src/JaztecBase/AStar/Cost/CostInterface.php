<?php

namespace JaztecBase\AStar\Cost;

/**
 * 
 */
interface ConstInterface
{
    /**
     * Interface for the cost part of the A* algoritm. Represented in an
     * unsigned integer;
     * @return int
     */
    public function getCost();
}
