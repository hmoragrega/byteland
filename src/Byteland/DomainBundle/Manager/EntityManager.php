<?php

namespace Byteland\DomainBundle\Manager;

use InvalidArgumentException;
use Byteland\DomainBundle\Entity\Entity;
use Byteland\DomainBundle\Repository\EntityRepository;
use Byteland\DomainBundle\Exception\ValidatorException;
use Byteland\DomainBundle\Exception\EntityNotFoundException;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Byteland\DomainBundle\Exception\InvalidSearchCriteriaException;

/**
 * Manages the business logic for the given entity
 *
 * @package Byteland\DomainBundle
 */
abstract class EntityManager
{
    /**
     * The validator service
     *
     * @var RecursiveValidator
     */
    protected $validator;

    /**
     * The entities repository
     *
     * @var EntityRepository
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param RecursiveValidator $validator
     * @param EntityRepository   $repository
     */
    public function __construct(
        RecursiveValidator $validator,
        EntityRepository $repository
    ) {
        $this->validator  = $validator;
        $this->repository = $repository;
    }

    /**
     * Build a new entity with the given parameters
     *
     * @param array $params
     *
     * @return Entity
     */
    abstract public function factory(array $params = []);

    /**
     * Saves the entity
     *
     * @param Entity $entity Entity to be saved
     *
     * @throws \Exception When there is a failure saving the entity
     */
    public function save(Entity $entity)
    {
        $this->validate($entity);
        $this->repository->persist($entity);
    }

    /**
     * Updates an entity with given params
     *
     * @param Entity $client
     * @param array  $params
     *
     * @return Entity
     */
    abstract public function update($client, array $params);

    /**
     * Deleets the entity
     *
     * @param Entity $entity
     */
    public function delete(Entity $entity)
    {
        $this->repository->remove($entity);
    }

    /**
     * Deletes the restaurant by the id
     *
     * @param int $id
     */
    public function deleteById($id)
    {
        $this->repository->removeById($id);
    }

    /**
     * Validates a entity
     *
     * @param Entity $entity
     */
    public function validate(Entity $entity)
    {
        $errors = $this->validator->validate($entity);

        if ($errors->count() > 0) {
            throw new ValidatorException($errors, 'There were validation errors');
        }
    }

    /**
     * Searchs entitities validating the criteria first
     *
     * @param array $criteria
     *
     * @return Entity[]
     *
     * @throws InvalidSearchCriteriaException
     */
    public function findBy(array $criteria)
    {
        $invalidCriteria = array_diff_key(
            $criteria,
            $this->repository->getSearchCriteria()
        );

        if (!empty($invalidCriteria)) {
            throw new InvalidSearchCriteriaException(
                $invalidCriteria,
                $this->repository->getSearchCriteria(),
                'Invalid search filters found'
            );
        }

        return $this->repository->findBy($criteria);
    }

    /**
     * Searchs entitys validating the criteria first
     *
     * @param mixed $id Id of the entity
     *
     * @return Entity
     *
     * @throws InvalidArgumentException
     * @throws EntityNotFoundException
     */
    public function find($id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Missing entity id');
        }

        $entity = $this->repository->find($id);
        if (null === $entity) {
            throw new EntityNotFoundException(
                "The entity with id $id could not be found"
            );
        }

        return $entity;
    }
}