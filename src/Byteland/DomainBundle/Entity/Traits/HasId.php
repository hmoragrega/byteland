<?php

namespace Byteland\DomainBundle\Entity\Traits;

/**
 * A trait used by entities that have an id
 *
 * @package Byteland\DomainBundle
 */
trait HasId
{
    /**
     * The entity id
     *
     * @var int
     */
    private $id;

    /**
     * Returns the id of the entity
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id of the entity
     *
     * @return int
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}