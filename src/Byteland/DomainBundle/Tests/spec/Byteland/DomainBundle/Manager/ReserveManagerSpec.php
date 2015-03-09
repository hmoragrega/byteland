<?php

namespace spec\Byteland\DomainBundle\Manager;

use Byteland\DomainBundle\Entity\Reserve;
use Byteland\DomainBundle\Manager\AvailableRestaurantManager;
use Byteland\DomainBundle\Manager\ClientManager;
use Byteland\DomainBundle\Repository\MySQL\ReserveRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ReserveManagerSpec extends ObjectBehavior
{
    function let(
        RecursiveValidator $validator,
        ReserveRepository $repository,
        AvailableRestaurantManager $availableRestaurantManager,
        ClientManager $clientManager
    ) {
        $this->beConstructedWith(
            $validator,
            $repository,
            $availableRestaurantManager,
            $clientManager
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Manager\ReserveManager');
    }

    function it_is_an_reserve_factory()
    {
        $this->factory()->shouldReturnAnInstanceOf('Byteland\DomainBundle\Entity\Reserve');
    }

    function it_updates_the_reserve(
        Reserve $reserve,
        AvailableRestaurantManager $availableRestaurantManager,
        ClientManager $clientManager
    ) {
        $availableRestaurantManager->find('foo');
        $clientManager->find('bar');
        $reserve->setAvailableRestaurant('foo')->willReturn('foo');
        $reserve->setClient('bar')->willReturn('bar');

        $this->update($reserve, [[
            'availableRestaurant' => 'foo',
            'client'              => 'bar',
        ]]);
    }
}
