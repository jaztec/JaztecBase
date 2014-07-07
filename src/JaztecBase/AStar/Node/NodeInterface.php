<?php

namespace JaztecBase\AStar\Node;

interface NodeInterface
{
    /**
     * This function returns an identifier to recognize this node.
     * @return mixed
     */
    public function getId();

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
     * Returns the complete cost of this node represented as an integer.
     * @return int
     */
    public function getCombinedCost();
    
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

    /**
     * @return \JaztecBase\AStar\Node\NodeInterface 
     * The node which is currently the active parent.
     */    
    public function getParentNode();

    /**
     * Sets the parent node of this node.
     * @param \JaztecBase\AStar\Node\NodeInterface $parentNode
     */
    public function setParentNode(NodeInterface $parentNode);

    /**
     * Get the adjacent nodes from a node.
     * @return \Doctrine\Common\Collections\ArrayCollection The adjacent nodes.
     */
    public function getAdjacentNodes();

    /**
     * Function returning wether or not this node has to be included into the 
     * search.
     * @return bool
     */
    public function isValidNode();
}
