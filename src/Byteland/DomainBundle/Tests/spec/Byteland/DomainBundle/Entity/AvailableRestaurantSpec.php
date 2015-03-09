<?php

namespace spec\Byteland\DomainBundle\Entity;

use PhpSpec\ObjectBehavior;

class AvailableRestaurantSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Entity\AvailableRestaurant');
    }

    // Trait testing HasId
    function it_has_an_id()
    {
        $this->setId('foo')->getId()->shouldBe('foo');
    }

    function it_has_restaurant($restaurant)
    {
        $restaurant->beADoubleOf('Byteland\DomainBundle\Entity\Restaurant');
        $this->setRestaurant($restaurant)->getRestaurant()->shouldReturn($restaurant);
    }

    function it_has_a_reserve_list($reserveList)
    {
        $reserveList->beADoubleOf('Byteland\DomainBundle\Entity\ReserveList');

        $this
            ->setReserveList($reserveList)
            ->getReserveList()
            ->shouldReturn($reserveList);
    }

    function it_is_unique_by_restaurant_and_reserve_list($restaurant, $reserveList)
    {
        $restaurant->beADoubleOf('Byteland\DomainBundle\Entity\Restaurant');
        $reserveList->beADoubleOf('Byteland\DomainBundle\Entity\ReserveList');

        $this
            ->setRestaurant($restaurant)
            ->setReserveList($reserveList)
            ->getUniqueCriteria()
            ->shouldReturn([
                'restaurant'  => $restaurant,
                'reserveList' => $reserveList,
            ]);
    }

    function it_is_json_serializable($restaurant, $reserveList)
    {
        $restaurant->beADoubleOf('Byteland\DomainBundle\Entity\Restaurant');
        $reserveList->beADoubleOf('Byteland\DomainBundle\Entity\ReserveList');

        $this
            ->setId('foo')
            ->setRestaurant($restaurant)
            ->setReserveList($reserveList)
            ->jsonSerialize()
            ->shouldReturn([
                'id'          => 'foo',
                'reserveList' => $reserveList,
                'restaurant'  => $restaurant,
            ]);
    }
}
