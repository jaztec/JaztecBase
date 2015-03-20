<?php

namespace JaztecBase\ORM;

use Doctrine\ORM\EntityManager;

interface EntityManagerAwareInterface
{
    /**
     * Set the entity manager in this object.
     * @param EntityManager $em
     */
    public function setEntityManager(EntityManager $em);
    
    /**
     * Retrieve the entity manager from this object.
     * @return EntityManager
     */
    public function getEntityManager();
}
