<?php

namespace Byteland\DomainBundle\Entity\Traits;

/**
 * A trait used by entities that have name
 *
 * @package Byteland\DomainBundle
 */
trait HasName
{
    /**
     * The entity name
     *
     * @var string
     */
    private $name;

    /**
     * Returns the name of the entity
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the entity
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}