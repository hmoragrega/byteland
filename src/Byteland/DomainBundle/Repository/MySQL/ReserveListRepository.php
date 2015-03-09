<?php

namespace Byteland\DomainBundle\Repository\MySQL;

use DateTime;

/**
 * Manages the persistance of the reservelist entities
 *
 * @package Byteland\DomainBundle
 */
class ReserveListRepository extends DoctrineRepository
{
    /**
     * Finds entities based on the given criteria
     *
     * @param array $criteria
     *
     * @return \Byteland\DomainBundle\Entity\Entity[]
     */
    public function findBy(array $criteria = [])
    {
        if (isset($criteria['date']) && !$criteria['date'] instanceof DateTime) {
            $criteria['date'] = DateTime::createFromFormat('Y-m-d', $criteria['date']);
        }

        return $this->repository->findBy($criteria);
    }

    /**
     * Allowed search criteria for reservelists
     *
     * @return array
     */
    public function getSearchCriteria()
    {
        return [
            'date'       => 'Date of the reserve',
            'restaurant' => 'Restaurant of the reserve',
        ];
    }
}