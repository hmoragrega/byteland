<?php

namespace Byteland\DomainBundle\Manager;

use Byteland\DomainBundle\Entity\Client;

/**
 * Manages the business logic for the Client entity
 *
 * @package Byteland\DomainBundle
 */
class ClientManager extends EntityManager
{
    /**
     * Create a new client entity
     *
     * @param array $params
     *
     * @return Client
     */
    public function factory(array $params = [])
    {
        return $this->update(new Client(), $params);
    }

    /**
     * Updates the values of a client entity
     *
     * @param Client $client
     * @param array $params
     *
     * @return Client
     */
    public function update($client, array $params)
    {
        if (isset($params['name'])) {
            $client->setName($params['name']);
        }

        return $client;
    }
}