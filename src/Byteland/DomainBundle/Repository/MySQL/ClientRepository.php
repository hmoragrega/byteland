<?php

namespace Byteland\DomainBundle\Repository\MySQL;

/**
 * Manages the persistance of the client entities
 *
 * @package Byteland\DomainBundle
 */
class ClientRepository extends DoctrineRepository
{
    /**
     * Allowed search criteria for clients
     *
     * @return array
     */
    public function getSearchCriteria()
    {
        return [
            'name' => 'Name of the client',
        ];
    }
}