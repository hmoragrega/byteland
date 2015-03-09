<?php

namespace Byteland\DomainBundle\Entity;

/**
 * Defines the reserve of a client in a restaurant for a date
 *
 * @package Byteland\DomainBundle
 */
class Reserve implements Entity
{
    use Traits\HasId;

    /**
     * The restaurant of the reserve
     *
     * @var AvailableRestaurant
     */
    private $availableRestaurant;

    /**
     * The client that made the reserve
     *
     * @var Client
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->availableRestaurant = new AvailableRestaurant();
        $this->client              = new Client();
    }

    /**
     * Get the available restaurant
     *
     * @return AvailableRestaurant
     */
    public function getAvailableRestaurant()
    {
        return $this->availableRestaurant;
    }

    /**
     * Set the available restaurant
     *
     * @param AvailableRestaurant $restaurant
     *
     * @return AvailableRestaurant
     */
    public function setAvailableRestaurant(AvailableRestaurant $restaurant)
    {
        $this->availableRestaurant = $restaurant;

        return $this;
    }

    /**
     * Gets the client that made the reserve
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Sets the client for the reserve
     *
     * @param Client $client
     *
     * @return Client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Unique reserve criterias
     *
     * @return array
     */
    public function getUniqueCriteria()
    {
        return [
            'client'              => $this->client,
            'availableRestaurant' => $this->availableRestaurant,
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
            'id'                  => $this->getId(),
            'client'              => $this->client,
            'availableRestaurant' => $this->availableRestaurant,
        ];
    }
}