<?php

namespace Byteland\DomainBundle\Entity;

/**
 * Defines the client entity
 *
 * @package Byteland\DomainBundle
 */
class Client implements Entity
{
    use Traits\HasId;
    use Traits\HasName;

    /**
     * Unique client criterias
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
            'id'   => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}