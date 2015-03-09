<?php

namespace Byteland\DomainBundle\Tests\unit\Byteland\DomainBundle\Repository;

use Byteland\DomainBundle\Entity\Reserve;
use Byteland\DomainBundle\Entity\AvailableRestaurant;
use Byteland\DomainBundle\Tests\unit\dbunit\DbTestCase;
use Byteland\DomainBundle\Repository\MySQL\ReserveRepository;

/**
 * @package Byteland\DomainBundle
 */
class ReserveRepositoryTest extends DbTestCase
{
    /**
     * @var ReserveRepository
     */
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = new ReserveRepository(
            self::$entityManager,
            '\Byteland\DomainBundle\Entity\Reserve'
        );
    }

    public function countRestaurantReservesProvider()
    {
        return [
            'Restaurant with one reserve' => [
                'id'       => 1,
                'expected' => 1,
            ],
            'Restaurant with multiple reserves' => [
                'id'       => 2,
                'expected' => 2,
            ],
            'Restaurant without reserves' => [
                'id'       => 3,
                'expected' => 0,
            ],
        ];
    }

    /**
     * @dataProvider countRestaurantReservesProvider
     *
     * @param $id
     * @param $expected
     */
    public function testCountRestaurantReserves($id, $expected)
    {
        $reserve = new Reserve();
        $reserve->setAvailableRestaurant(
            (new AvailableRestaurant())->setId($id)
        );

        $result = $this->repository->countRestaurantReserves($reserve);

        $this->assertEquals($expected, $result, 'The count is wrong');
    }
}