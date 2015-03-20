<?php

namespace JaztecBase\ORM;

use Doctrine\ORM\EntityManager;

/**
 * @package JaztecBase\ORM
 * @author Jasper van Herpt <jasper.v.herpt@gmail.com>
 */
trait EntityManagerAwareTrait
{
    /** @var EntityManager */
    protected $em;
    
    public function getEntityManager()
    {
        return $this->em;
    }
    
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
}