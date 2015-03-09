<?php


namespace Byteland\DomainBundle\Repository;

use Byteland\DomainBundle\Entity\Entity;

/**
 * Works with the entities at the persistance layer
 *
 * @package Byteland\DomainBundle
 */
interface EntityRepository
{
    /**
     * Finds entities based on the given criteria
     *
     * @param array $criteria
     *
     * @return \Byteland\DomainBundle\Entity\Entity[]
     */
    public function findBy(array $criteria = []);

    /**
     * Finds the entity for the given id
     *
     * @param mixed $id
     *
     * @return \Byteland\DomainBundle\Entity\Entity
     */
    public function find($id);

    /**
     * Stores an entity
     *
     * @param $entity
     *
     * @return mixed
     */
    public function persist(Entity $entity);

    /**
     * Removes an entity
     *
     * @param $entity
     *
     * @return mixed
     */
    public function remove(Entity $entity);

    /**
     * Removes an entity by the id
     *
     * @param mixed $id
     */
    public function removeById($id);

    /**
     * Returns an array of properties with description that can be used to
     * search entities on this repository
     *
     * Return example:
     *
     * [
     *      'name'     => 'Name of the client',
     *      'passport' => 'Passport ID of the client'
     * ]
     *
     * @return array
     */
    public function getSearchCriteria();
}