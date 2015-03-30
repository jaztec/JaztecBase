<?php

namespace JaztecBase\Mapper;

use Doctrine\ORM\EntityManager;
use JaztecBase\ORM\EntityManagerAwareInterface;
use JaztecBase\Entity\AbstractEntity;

/**
 * Doctrine Mapper
 *
 * Provides common doctrine methods
 */
abstract class AbstractDoctrineMapper extends AbstractMapper implements
    EntityManagerAwareInterface
{
    const TYPE_SERIALIZEDARRAY  = 0x1;
    const TYPE_ENTITYARRAY      = 0x2;

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
        return $this->getEntityManager()->getRepository($this->entityName);
    }

    /**
     * @param  array|\Doctrine\Common\Persistence\ObjectRepository $repo
     * @param  int                                                 $type
     * @return array
     */
    protected function processResult($repo, $type)
    {
        // Testing on input parameters
        if (!$repo instanceof \Doctrine\Common\Persistence\ObjectRepository &&
            !is_array($repo)) {
            throw new Exception(
                __CLASS__ . ' expects an array or a
                \Doctrine\Common\Persistence\ObjectRepository. ' .
                class_name($repo) . ' given.'
            );
        }
        switch ($type) {
            case AbstractDoctrineMapper::TYPE_SERIALIZEDARRAY:
                $result = [];
                foreach ($repo as $obj) {
                    /* @var $obj \JaztecBase\Entity\EntityInterface */
                    if ($obj instanceof \JaztecBase\Entity\EntityInterface) {
                        $result[] = $obj->toArray();
                    } elseif (is_array($obj)) {
                        $result[] = $obj;
                    }
                }
                break;
            case AbstractDoctrineMapper::TYPE_ENTITYARRAY:
                if (!is_array($repo)) {
                    $repo = [$repo];
                }
                $result = $repo;
                break;
        }

        return $result;
    }

    /**
     * Will return an array with all the entities found.
     *
     * @return AbstractEntity[] An array with serialzed entities.
     */
    public function findAll()
    {
        return $this->processResult(
            $this->getRepository()->findAll(),
            self::TYPE_SERIALIZEDARRAY
        );
    }

    /**
     * Persists and saves an entity to the database.
     *
     * @param AbstractEntity $entity
     */
    public function save(AbstractEntity $entity)
    {
        if (empty($entity->getId())) {
            $this->getEntityManager()->persist($entity);
        }
        $this->getEntityManager()->flush($entity);
    }

    /**
     * Removes an entity from the database.
     *
     * @param AbstractEntity $entity
     */
    public function remove(AbstractEntity $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param int $id
     * @return AbstractEntity
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }
}
