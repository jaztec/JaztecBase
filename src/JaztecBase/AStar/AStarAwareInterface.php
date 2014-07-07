<?php

namespace JaztecBase\AStar;

use JaztecBase\AStar\AStarInterface;

interface AStarAwareInterface
{
    /**
     * @return \JaztecBase\AStar\AStar
     */
    public function getAStar();

    /**
     * @param \JaztecBase\AStar\AStarInterface $aStar
     */
    public function setAStar(AStarInterface $aStar);
}
