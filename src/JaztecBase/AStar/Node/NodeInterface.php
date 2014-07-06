<?php

namespace JaztecBase\AStar\Node;

interface NodeInterface
{
    /**
     * Get the object responsible for the cost part of the A* algoritm. It needs 
     * to implement the CostInterface.
     * @return \JaztecBase\AStar\Cost\CostInterface
     */
    public function getCost();

    /**
     * Get the object responsible for the heuristic part of the A* algoritm. It 
     * needs to implement the HeuristicInterface.
     * @return \JaztecBase\AStar\Heuristic\HeuristicInterface
     */
    public function getHeuristic();

    /**
     * @return \JaztecBase\AStar\Node\EdgeInterface[]
     * Array containing the adjecent nodes to this node;
     */
    public function getEdges();

    /**
     * @param mixed $identifier
     * @return \JaztecBase\AStar\Node\EdgeInterface Specific edge of this node.
     */
    public function getEdge($identifier);
}
