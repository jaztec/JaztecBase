<?php

namespace JaztecBase\AStar;

use JaztecBase\AStar\Node\NodeInterface;

interface AStarInterface
{
    /**
     * @return \JaztecBase\AStar\Node\NodeInterface[]|NULL The calculated route betweeh 
     * the given nodes or NULL when no route has been found.
     */
    public function getRoute(NodeInterface $startNode, NodeInterface $endNode);

    /**
     * Get the current start node.
     * @return \JaztecBase\AStar\Node\NodeInterface
     */
    public function getStartNode();

    /**
     * Get the current start node.
     * @param \JaztecBase\AStar\Node\NodeInterface $startNode
     */
    public function setStartNode(NodeInterface $startNode);

    /**
     * Get the current end node.
     * @return \JaztecBase\AStar\Node\NodeInterface
     */
    public function getEndNode();

    /**
     * Set the current end node.
     * @param \JaztecBase\AStar\Node\NodeInterface $endNode
     */
    public function setEndNode(NodeInterface $startNode);

    /**
     * Return the next best node in our collection.
     * @return \JaztecBase\AStar\Node\NodeInterface
     */
    public function getNextNode();
}
