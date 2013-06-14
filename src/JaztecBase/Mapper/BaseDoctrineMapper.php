<?php

namespace JaztecBase\Mapper;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

use JaztecBase\Entity\Entity;

/**
 * Doctrine Mapper
 * 
 * Provides common doctrine methods
 */
abstract class AbstractDoctrineMapper extends AbstractMapper
{
    const TYPE_SERIALIZEDARRAY = 0x1;
    const TYPE_ENTITYARRAY = 0x2;
    
    /**
     * @var EntityManager
     */
    protected $entityManager;
    
    /**
     * @var string
     */
    protected $entityName;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getDatabase()
    {
        return $this->entityManager->getConnection();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository($this->entityName);
    }
    
    /**
     * @param array|\Doctrine\Common\Persistence\ObjectRepository $repo
     * @param int $type
     * @return array
     */
    protected function processResult($repo, $type)
    {
        switch($type){
            case AbstractDoctrineMapper::TYPE_SERIALIZEDARRAY:
                $result = array();
                foreach($repo as $obj) {
                    /* @var $obj \JaztecAcl\Entity\EntityInterface */
                    if($obj instanceof \JaztecBase\Entity\EntityInterface)
                        $result[] = $obj->serialize();
                }
                break;
            case AbstractDoctrineMapper::TYPE_ENTITYARRAY:
                if(!is_array($repo))
                    $repo = array($repo);
                $result = $repo;
                break;
        }
        return $result;
    }

    /**
     * Persists and saves an entity to the database.
     * 
     * @param \JaztecBase\Entity\Entity $entity
     */
    public function save(Entity $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}