<?php

namespace JaztecBase\AStar\Node;

interface EdgeInterface
{
    /**
     * Get the id of this edge
     * @return mixed The id of this node edge.
     */
    public function getId();

    /**
     * Get the nodes which are listed inside this edge.
     * @return \JaztecBase\AStar\Node\EdgeInterface[] The nodes.
     */
    public function getNodes();
}
