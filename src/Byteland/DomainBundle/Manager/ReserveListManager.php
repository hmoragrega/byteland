<?php

namespace Byteland\DomainBundle\Manager;

use DateTime;
use Byteland\DomainBundle\Entity\ReserveList;


use Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * Manages the business logic for the Client entity
 *
 * @package Byteland\DomainBundle
 */
class ReserveListManager extends EntityManager
{
    /**
     * Create a new client entity
     *
     * @param array $params
     *
     * @return ReserveList
     */
    public function factory(array $params = [])
    {
        return $this->update(new ReserveList(), $params);
    }

    /**
     * Updates the values of a client entity
     *
     * @param ReserveList $reserveList
     * @param array $params
     *
     * @return ReserveList
     */
    public function update($reserveList, array $params)
    {
        if (isset($params['date'])) {
            $reserveList->setDate(
                $this->getDateTimeFromString($params['date'])
            );
        }

        return $reserveList;
    }

    /**
     * Returns a date time only if the date string is a valid date with the
     * format Y-m-d
     *
     * @param string $dateString
     *
     * @return DateTime|null
     */
    protected function getDateTimeFromString($dateString)
    {
        $dateTime = DateTime::createFromFormat('Y-m-d', $dateString);

        return ($dateTime && $dateTime->format('Y-m-d') == $dateString)
            ? $dateTime
            : null;
    }
}