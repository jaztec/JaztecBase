<?php

namespace JaztecBase\AStar;

use JaztecBase\Service\AbstractService;
use JaztecBase\AStar\Node\NodeInterface;
use Doctrine\Common\Collections\ArrayCollection;

class AStar extends AbstractService implements
    AStarInterface
{
    /**
     * The nodes which need to be visited to calculate the route.
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $openNodes;

    /**
     * The nodes which are visited while calcutating the route.
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $visitedNodes;

    /**
     * The nodes the current AStart object is loaded with.
     * @var \Doctrine\Common\Collections\ArrayCollection[JaztecBase\AStar\Node\NodeInterface]
     */
    protected $nodes;

    /**
     * Only for private use. When TRUE the end node has been found by the algoritm.
     * @var bool
     */
    protected $foundEndNode;

    /**
     * Boolean to keeo track when the path has been found.
     * @var bool Will be set to TRUE when the path hes been resolved.
     */
    protected $resolvedPath;

    /**
     * @var \JaztecBase\AStar\Node\NodeInterface
     */
    protected $startNode;

    /**
     * @var \JaztecBase\AStar\Node\NodeInterface
     */
    protected $endNode;


    public function __construct()
    {
        $this->openNodes = new ArrayCollection;
        $this->closedNodes = new ArrayCollection;
        $this->resolvedPath = false;
        $this->foundEndNode = false;
    }

    /**
     * @return \JaztecBase\AStar\Node\NodeInterface[]|NULL The calculated route betweeh 
     * the given nodes or NULL when no route has been found.
     * @throws \JaztecBase\AStar\Exception
     */
    public function getRoute(Node\NodeInterface $startNode, Node\NodeInterface $endNode)
    {
        $path = new ArrayCollection;

        // Clear any remains of previous searches
        $this->resetValues();

        // Set some variables.
        $this->setStartNode($startNode);
        $this->setEndNode($endNode);
        
        // Add the start node to the open list.
        $this->openNodes->set($startNode->getId(), $startNode);
        
        // Start calculating at the start node and build a graph. Resolving as we go.
        /* @var $currentNode \JaztecBase\AStar\Node\NodeInterface */
        $currentNode = $this->buildRoute();

        // When the end node hasn't been found by the algoritm return NULL
        // immitiatly;
        if (!$this->foundEndNode) {
            return null;
        }        
        
        // After finding the end node resolve the best path. $currentNode is the
        // final node.
        $path = $this->fetchPathToStartNode($currentNode);

        // Return the path when it has been found.
        if ($this->resolvedPath) {
            return $path;
        }

        // Ultimatly return NULL. To acknowledge shit has hit the fan.
        return null;
    }

    /**
     * Resets all search values inside this object.
     */
    protected function resetValues()
    {
        $this->openNodes->clear();
        $this->visitedNodes->clear();
        $this->resolvedPath = false;
        $this->foundEndNode = false;
    }

    /**
     * Set the current start node.
     */
    public function getStartNode()
    {
        return $this->startNode;
    }

    /**
     * Get the current start node.
     * @param \JaztecBase\AStar\Node\NodeInterface $startNode
     */
    public function setStartNode(NodeInterface $startNode)
    {
        $this->startNode = $startNode;
    }

    /**
     * Get the current end node.
     */
    public function getEndNode()
    {
        return $this->endNode;
    }

    /**
     * Set the current end node.
     * @param \JaztecBase\AStar\Node\NodeInterface $endNode
     */
    public function setEndNode(NodeInterface $endNode)
    {
        $this->endNode = $endNode;
    }

    /**
     * Return the next best node in our collection.
     * @return \JaztecBase\AStar\Node\NodeInterface
     */
    public function getNextNode()
    {
        $bestNode = null;
    }

    /**
     * Get the adjacent nodes from a node.
     * @param \JaztecBase\AStar\Node\NodeInterface $node
     * @return \Doctrine\Common\Collections\ArrayCollection The adjacent nodes.
     */
    protected function getAdjacentNodes(Node\NodeInterface $node)
    {
        $nodes = new ArrayCollection;
        foreach ($node->getEdges() as $edge) {
            /* @var $edge \JaztecBase\AStar\Node\EdgeInterface */
            foreach ($edge->getNodes() as $adjacentNode) {
                $nodes->add($adjacentNode);
            }
        }
        return $nodes;
    }

    /**
     * Does the actual working towards the end node.
     * @return \JaztecBase\AStar\Node\NodeInterface|NULL 
     * The last visited node or NULL when all nodes have been scanned.
     */
    protected function buildRoute()
    {
        $currentNode = $this->getStartNode();
        while (!$this->openNodes->isEmpty() && !$this->foundEndNode) {
            // Remove the current node from the open list and add it to the visited
            // list.
            $this->openNodes->remove($currentNode->getId());
            $this->visitedNodes->set($currentNode->getId(), $currentNode);
            
            // Check if we reached the end node. If so no need to look on.
            if ($currentNode->getId() === $this->getEndNode()->getId()) {
                $this->foundEndNode = true;
                break;
            }

            // The end node has not been reached, add the non visited edges to
            // the open stack.
            foreach($this->getAdjacentNodes($currentNode) as $adjacentNode) {
                /* @var $adjacentNode \JaztecBase\AStar\Node\NodeInterface */
                if ($this->visitedNodes->get($adjacentNode->getId())
                    || $this->openNodes->get($adjacentNode->getId())) {
                    continue;
                }
                $this->openNodes->set($adjacentNode->getId(), $adjacentNode);
            }

            // Set the next best node as the current node
            $currentNode = $this->getNextNode();
        }
        return $currentNode;
    }

    /**
     * Look up the parent stack of the fetched end node back to the start node.
     * @param \JaztecBase\AStar\Node\NodeInterface $node The node to start calculating from.
     * @return \Doctrine\Common\Collections\ArrayCollection A collection of nodes leading to the path.
     */
    protected function fetchPathToStartNode(NodeInterface $node)
    {
        $path = new ArrayCollection;
        /* @var $currentNode \JaztecBase\AStar\Node\NodeInterface */
        $currentNode = $node;
        while ($this->resolvedPath === false && $currentNode) {
            // Test if we're back at the start node. If so our goal is complete.
            if ($currentNode->getId() === $this->getStartNode()->getId()) {
                $this->resolvedPath = true;
                break;
            }

            // If we've not reached our goal add the current node to the path and
            // further check our parent stack.
            $path->add($currentNode);
            $currentNode = $currentNode->getParentNode();
        }
        return $path;
    }
}
