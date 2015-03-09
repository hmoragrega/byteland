<?php


namespace Byteland\DomainBundle\Repository\MySQL;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DBALException;
use Byteland\DomainBundle\Entity\Entity;
use Byteland\DomainBundle\Repository\EntityRepository;
use Byteland\DomainBundle\Exception\EntityNotUniqueException;
use Byteland\DomainBundle\Exception\DomainIntegrityException;

/**
 * Manages the persistance of the entities with doctrine
 *
 * @package Byteland\DomainBundle
 */
abstract class DoctrineRepository implements EntityRepository
{
    /**
     * A hacky way to determine if the query failed for a foreign key
     */
    const FK_VIOLATION_REGEX = '/Integrity constraint violation/i';

    /**
     * Doctrine entity manager
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Doctrine's entity repository
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager The doctrine entity manager
     * @param string        $entityClass   The managed entity fqn
     */
    public function __construct(EntityManager $entityManager, $entityClass)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $entityManager->getRepository($entityClass);
        $this->entityClass   = $entityClass;
    }

    /**
     * Finds entities based on the given criteria
     *
     * @param array $criteria
     *
     * @return \Byteland\DomainBundle\Entity\Entity[]
     */
    public function findBy(array $criteria = [])
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * Finds the entity for the given id
     *
     * @param mixed $id
     *
     * @return \Byteland\DomainBundle\Entity\Entity
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Persist an entity
     *
     * @param Entity $entity
     * @return mixed
     * @throws DBALException
     * @throws \Exception
     */
    public function persist(Entity $entity)
    {
        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch(DBALException $exception) {
            $this->checkIfNotUnique($entity);
            throw $exception;
        }

        return $entity;
    }

    /**
     * Removes an entity
     *
     * @param Entity $entity
     *
     * @return void
     *
     * @throws DBALException
     */
    public function remove(Entity $entity)
    {
        try {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        } catch(DBALException $exception) {
            $this->checkForeignKeyViolation($exception);
            throw $exception;
        }
    }

    /**
     * Removes an entity by the id
     *
     * @param mixed $id
     */
    public function removeById($id)
    {
        $entity = $this->entityManager->getPartialReference(
            $this->entityClass,
            ['id' => $id]
        );

        $this->remove($entity);
    }

    /**
     * Check if a foreign key constraint has been violated
     *
     * @param DBALException $exception
     *
     * @throws DomainIntegrityException
     */
    protected function checkForeignKeyViolation(DBALException $exception)
    {
        $foreignKeyViolation = preg_match
        (
            self::FK_VIOLATION_REGEX,
            $exception->getMessage()
        );

        if ($foreignKeyViolation) {
            throw new DomainIntegrityException(
                "There are other entites associated with this one"
            );
        }
    }

    /**
     * Validates that a resturant doesn't exist
     *
     * @param Entity $entity
     *
     * @return void
     *
     * @throws EntityNotUniqueException
     */
    protected function checkIfNotUnique(Entity $entity)
    {
        $criteria = $entity->getUniqueCriteria();
        $another = $this->repository->findOneBy($entity->getUniqueCriteria());

        if(null !== $another && $another->getId() != $entity->getId()) {
            throw new EntityNotUniqueException(
                $criteria,
                "This entity already exists"
            );
        }
    }
}