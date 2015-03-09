<?php

namespace Byteland\DomainBundle\Manager;

use Byteland\DomainBundle\Entity\AvailableRestaurant;
use Byteland\DomainBundle\Entity\Entity;
use Byteland\DomainBundle\Entity\Reserve;
use Byteland\DomainBundle\Exception\EntityNotUniqueException;
use Byteland\DomainBundle\Exception\ValidatorException;
use Byteland\DomainBundle\Repository\MySQL\ReserveRepository;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * Manages the business logic for the Reserve entity
 *
 * @package Byteland\DomainBundle
 */
class ReserveManager extends EntityManager
{
    /**
     * Manager for available restaurant entities
     *
     * @var AvailableRestaurantManager
     */
    protected $availableRestaurantManager;

    /**
     * Manager for client entities
     *
     * @var ClientManager
     */
    protected $clientManager;

    /**
     * Constructor
     *
     * @param RecursiveValidator $validator
     * @param ReserveRepository $repository
     * @param AvailableRestaurantManager $availableRestaurantManager
     * @param ClientManager $clientManager
     */
    public function __construct(
        RecursiveValidator $validator,
        ReserveRepository $repository,
        AvailableRestaurantManager $availableRestaurantManager,
        ClientManager $clientManager
    ) {
        parent::__construct($validator, $repository);
        $this->availableRestaurantManager = $availableRestaurantManager;
        $this->clientManager              = $clientManager;
    }

    /**
     * Create a new reserve entity
     *
     * @param array $params
     *
     * @return Reserve
     */
    public function factory(array $params = [])
    {
        return $this->update(new Reserve(), $params);
    }

    /**
     * Updates the values of a reserve entity
     *
     * @param Reserve $reserve
     * @param array $params
     *
     * @return Reserve
     */
    public function update($reserve, array $params)
    {
        if (isset($params['availableRestaurant'])) {
            $reserve->setAvailableRestaurant(
                $this->availableRestaurantManager->find(
                    $params['availableRestaurant']
                )
            );
        }

        if (isset($params['client'])) {
            $reserve->setClient(
                $this->clientManager->find($params['client'])
            );
        }

        return $reserve;
    }

    /**
     * Validates a entity
     *
     * @param Entity $entity
     */
    public function validate(Entity $entity)
    {
        parent::validate($entity);

        $this->validateCapacity($entity);
    }

    /**
     * Validates that the restaurant is not at full capacity before reserve
     *
     * @param Reserve $reserve
     */
    protected function validateCapacity(Reserve $reserve)
    {
        $reserves = $this->repository->countRestaurantReserves($reserve);

        $capacity = $reserve->getAvailableRestaurant()
            ->getRestaurant()
            ->getCapacity();

        if ($reserves >= $capacity) {
            throw new ValidatorException(
                ['restaurant' => $reserve->getAvailableRestaurant()->getRestaurant()],
                'The restaurant at full capacity for this date'
            );
        }
    }
}