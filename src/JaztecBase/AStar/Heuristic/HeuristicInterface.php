<?php

namespace JaztecBase\AStar\Heuristic;

interface HeuristicInterface
{
    /**
     * Interface for the heuristic part of the A* algoritm. Represented in an
     * unsigned integer;
     * @return int
     */
    public function getHeuristic();
}
