<?php

namespace Byteland\DomainBundle\Entity;

/**
 * Defines the restaurant entity
 *
 * @package Byteland\DomainBundle
 */
class Restaurant implements Entity
{
    use Traits\HasId;
    use Traits\HasName;

    /**
     * Maximum capacity of the restaurant
     *
     * @var int
     */
    private $capacity;

    /**
     * Gets the restaurant capacity
     *
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Sets the restaurant capacity
     *
     * @param int $capacity
     * @return $this
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

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
            'name' => $this->getName()
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
            'name'        => $this->getName(),
            'capacity'    => $this->getCapacity(),
        ];
    }
}