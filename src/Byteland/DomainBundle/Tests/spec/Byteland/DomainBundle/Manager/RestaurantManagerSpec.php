<?php

namespace spec\Byteland\DomainBundle\Manager;

use Byteland\DomainBundle\Entity\Restaurant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Byteland\DomainBundle\Repository\MySQL\RestaurantRepository;

class RestaurantManagerSpec extends ObjectBehavior
{
    function let(RecursiveValidator $validator, RestaurantRepository $repository)
    {
        $this->beConstructedWith($validator, $repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Manager\RestaurantManager');
    }

    function it_is_a_restaurant_factory()
    {
        $this->factory()->shouldReturnAnInstanceOf('Byteland\DomainBundle\Entity\Restaurant');
    }

    function it_updates_the_restaurant(Restaurant $restaurant)
    {
        $restaurant->setName('foo')->shouldBeCalled();
        $restaurant->setCapacity('bar')->shouldBeCalled();

        $this->update($restaurant, [
            'name'     => 'foo',
            'capacity' => 'bar',
        ]);
    }
}
