<?php


namespace Byteland\DomainBundle\Repository\MySQL;

/**
 * Manages the persistance of the restaurant entities
 *
 * @package Byteland\DomainBundle
 */
class RestaurantRepository extends DoctrineRepository
{
    /**
     * Allowed search criteria for restaurants
     *
     * @return array
     */
    public function getSearchCriteria()
    {
        return [
            'name'     => 'Name of the restaurant',
            'capacity' => 'Capacity of the restaurant',
        ];
    }
}