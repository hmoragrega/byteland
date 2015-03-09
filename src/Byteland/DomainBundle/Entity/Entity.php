<?php

namespace Byteland\DomainBundle\Entity;

use JsonSerializable;

/**
 * Interface Entity
 *
 * @package Byteland\DomainBundle
 */
interface Entity extends JsonSerializable
{
    /**
     * Returns the id of the entity
     *
     * @return mixed
     */
    public function getId();

    /**
     * Return an array of array criterias that makes this entity unique,
     * being the key the property name
     *
     * Return example:
     *
     * [
     *      'name' => 'Jhon doe'
     * ]
     *
     * @return array
     */
    public function getUniqueCriteria();
}