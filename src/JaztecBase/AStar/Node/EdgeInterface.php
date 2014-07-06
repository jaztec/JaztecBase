<?php

namespace JaztecBase\AStar\Node;

interface EdgeInterface
{
    /**
     * Get the id of this edge
     * @return string The id of this node edge.
     */
    public function getId();

    /**
     * Get the nodes which are connected.
     * @return \JaztecBase\AStar\Node\EdgeInterface[] The nodes.
     */
    public function getNodes();

    /**
     * @return \JaztecBase\AStar\Node\NodeInterface 
     * The node which is currently the active parent.
     */
    public function getParentNode();
}
