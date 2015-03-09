<?php

namespace spec\Byteland\DomainBundle\Manager;

use Byteland\DomainBundle\Entity\AvailableRestaurant;
use Byteland\DomainBundle\Manager\ReserveListManager;
use Byteland\DomainBundle\Manager\RestaurantManager;
use Byteland\DomainBundle\Repository\MySQL\AvailableRestaurantRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class AvailableRestaurantManagerSpec extends ObjectBehavior
{
    function let(
        RecursiveValidator $validator,
        AvailableRestaurantRepository $repository,
        RestaurantManager $restaurantManager,
        ReserveListManager $reserveListManager
    ) {
        $this->beConstructedWith(
            $validator,
            $repository,
            $restaurantManager,
            $reserveListManager
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Manager\AvailableRestaurantManager');
    }

    function it_is_an_available_restaurant_factory()
    {
        $this->factory()->shouldReturnAnInstanceOf('Byteland\DomainBundle\Entity\AvailableRestaurant');
    }

    function it_updates_the_available_restaurant(
        AvailableRestaurant $availableRestaurant,
        RestaurantManager $restaurantManager,
        ReserveListManager $reserveListManager
    ) {
        $restaurantManager->find('foo');
        $reserveListManager->find('bar');
        $availableRestaurant->setRestaurant('foo')->willReturn('foo');
        $availableRestaurant->setReserveList('bar')->willReturn('bar');

        $this->update($availableRestaurant, [[
            'restaurant'  => 'foo',
            'reserveList' => 'bar',
        ]]);
    }
}
