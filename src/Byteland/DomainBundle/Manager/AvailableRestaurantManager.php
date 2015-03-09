<?php

namespace Byteland\DomainBundle\Manager;

use Byteland\DomainBundle\Entity\AvailableRestaurant;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Byteland\DomainBundle\Repository\MySQL\AvailableRestaurantRepository;

/**
 * Manages the business logic for the AvailableRestaurant entity
 *
 * @package Byteland\DomainBundle
 */
class AvailableRestaurantManager extends EntityManager
{
    /**
     * Manager for Restaurant entities
     *
     * @var RestaurantManager
     */
    protected $restaurantManager;

    /**
     * Manager for ReserveList entities
     *
     * @var ReserveListManager
     */
    protected $reserveListManager;

    /**
     * Constructor
     *
     * @param RecursiveValidator $validator
     * @param AvailableRestaurantRepository $repository
     * @param RestaurantManager $restaurantManager
     * @param ReserveListManager $reserveListManager
     */
    public function __construct(
        RecursiveValidator $validator,
        AvailableRestaurantRepository $repository,
        RestaurantManager $restaurantManager,
        ReserveListManager $reserveListManager
    ) {
        parent::__construct($validator, $repository);
        $this->restaurantManager  = $restaurantManager;
        $this->reserveListManager = $reserveListManager;
    }

    /**
     * Create a new availableRestaurant entity
     *
     * @param array $params
     *
     * @return AvailableRestaurant
     */
    public function factory(array $params = [])
    {
        return $this->update(new AvailableRestaurant(), $params);
    }

    /**
     * Updates the values of a availableRestaurant entity
     *
     * @param AvailableRestaurant $availableRestaurant
     * @param array $params
     *
     * @return AvailableRestaurant
     */
    public function update($availableRestaurant, array $params)
    {
        if (isset($params['restaurant'])) {
            $availableRestaurant->setRestaurant(
                $this->restaurantManager->find($params['restaurant'])
            );
        }

        if (isset($params['reserveList'])) {
            $availableRestaurant->setReserveList(
                $this->reserveListManager->find($params['reserveList'])
            );
        }

        return $availableRestaurant;
    }
}