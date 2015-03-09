<?php

namespace Byteland\DomainBundle\Manager;

use Byteland\DomainBundle\Entity\Restaurant;

/**
 * Manages the business logic for the Restaurannt entity
 *
 * @package Byteland\DomainBundle
 */
class RestaurantManager extends EntityManager
{
    /**
     * Create a new restaurant entity
     *
     * @param array $params
     *
     * @return Restaurant
     */
    public function factory(array $params = [])
    {
        return $this->update(new Restaurant(), $params);
    }

    /**
     * Updates the values of a restaurant entity
     *
     * @param Restaurant $restaurant
     * @param array $params
     *
     * @return Restaurant
     */
    public function update($restaurant, array $params)
    {
        if (isset($params['name'])) {
            $restaurant->setName($params['name']);
        }

        if (isset($params['capacity'])) {
            $restaurant->setCapacity($params['capacity']);
        }

        return $restaurant;
    }
}