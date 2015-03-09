<?php

namespace Byteland\DomainBundle\Entity;

use DateTime;

/**
 * Defines a reserve list, with a date and the available restaurants
 *
 * @package Byteland\DomainBundle
 */
class ReserveList implements Entity
{
    use Traits\HasId;

    /**
     * The date of the reserve list
     *
     * @var DateTime
     */
    protected $date;

    /**
     * The restaurants available for this date
     *
     * @var AvailableRestaurant[]
     */
    protected $availableRestaurants = [];

    /**
     * Gets the date of the reserve list
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date of the reserve list
     *
     * @param DateTime $date
     *
     * @return $this
     */
    public function setDate(DateTime $date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Gets the restaurant of the reserve
     *
     * @return AvailableRestaurant[]
     */
    public function getAvailableRestaurants()
    {
        return $this->availableRestaurants;
    }

    /**
     * Sets the restaurants of the reserve
     *
     * @param AvailableRestaurant[] $restaurants
     *
     * @return $this
     */
    public function setAvailableRestaurants(array $restaurants)
    {
        $this->availableRestaurants = $restaurants;

        return $this;
    }

    /**
     * Unique reserve list criterias
     *
     * @return array
     */
    public function getUniqueCriteria()
    {
        return [
            'date' => $this->getDate()
        ];
    }

    /**
     * Returns a json serializable array
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $availableRestaurants = [];
        foreach ($this->availableRestaurants as $id => $restaurant) {
            $availableRestaurants[] = $id;
        }

        $date = null !== $this->date ?
            $this->date->format('Y-m-d') :
            null;

        return [
            'id'                    => $this->getId(),
            'date'                  => $date,
            'availableRestaurants'  => $availableRestaurants,
        ];
    }
}