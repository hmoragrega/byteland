<?php

namespace Byteland\DomainBundle\Repository\MySQL;

/**
 * Manages the persistance of the available restaurants entities
 *
 * @package Byteland\DomainBundle
 */
class AvailableRestaurantRepository extends DoctrineRepository
{
    /**
     * Allowed search criteria for clients
     *
     * @return array
     */
    public function getSearchCriteria()
    {
        return [
            'restaurant'  => 'Search by restaurant id',
            'reserveList' => 'Search by the reserve list id',
        ];
    }
}