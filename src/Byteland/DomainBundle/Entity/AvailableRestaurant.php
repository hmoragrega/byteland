<?php

namespace Byteland\DomainBundle\Entity;

/**
 * Defines the restaurant entity
 *
 * @package Byteland\DomainBundle
 */
class AvailableRestaurant implements Entity
{
    use Traits\HasId;

    /**
     * The restaurant of the reserve
     *
     * @var Restaurant
     */
    private $restaurant;

    /**
     * The reserve list subscribed
     *
     * @var ReserveList
     */
    private $reserveList;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->restaurant  = new Restaurant();
        $this->reserveList = new ReserveList();
    }

    /**
     * @return Restaurant
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * @param Restaurant $restaurant
     *
     * @return $this
     */
    public function setRestaurant(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * @return ReserveList
     */
    public function getReserveList()
    {
        return $this->reserveList;
    }

    /**
     * @param ReserveList $reserveList
     * @return $this
     */
    public function setReserveList(ReserveList $reserveList)
    {
        $this->reserveList = $reserveList;

        return $this;
    }

    /**
     * Unique restaurant criterias
     *
     * @return array
     */
    public function getUniqueCriteria()
    {
        return [
            'restaurant'  => $this->restaurant,
            'reserveList' => $this->reserveList,
        ];
    }

    /**
     * Returns a json serializable array
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'          => $this->getId(),
            'reserveList' => $this->reserveList,
            'restaurant'  => $this->restaurant,
        ];
    }
}