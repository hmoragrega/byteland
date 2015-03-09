<?php

namespace Byteland\DomainBundle\Repository\MySQL;

use Byteland\DomainBundle\Entity\Reserve;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Manages the persistance of the reserve entities
 *
 * @package Byteland\DomainBundle
 */
class ReserveRepository extends DoctrineRepository
{
    /**
     * Counts the reserves done for a restaurant on a given date
     *
     * @param $reserve $reserve
     *
     * @return int
     */
    public function countRestaurantReserves(Reserve $reserve)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(Reserve::class, 'r');
        $rsm->addFieldResult('r', 'reserve_id', 'id');

        $result = $this->entityManager
            ->createNativeQuery(
                'SELECT reserve_id FROM reserve WHERE available_restaurant_id = ?',
                $rsm
            )
            ->setParameter(1, $reserve->getAvailableRestaurant()->getId())
            ->getResult();

        return count($result);
    }

    /**
     * Allowed search criteria for clients
     *
     * @return array
     */
    public function getSearchCriteria()
    {
        return [
            'client'              => 'Search by client id',
            'availableRestaurant' => 'Search by the available restaurant id',
        ];
    }
}