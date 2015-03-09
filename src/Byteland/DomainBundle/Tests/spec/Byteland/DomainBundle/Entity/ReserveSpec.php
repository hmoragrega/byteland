<?php

namespace spec\Byteland\DomainBundle\Entity;

use PhpSpec\ObjectBehavior;
use Byteland\DomainBundle\Entity\AvailableRestaurant;
use Byteland\DomainBundle\Entity\Client;

class ReserveSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Entity\Reserve');
    }

    // Trait testing HasId
    function it_has_an_id()
    {
        $this->setId('foo')->getId()->shouldBe('foo');
    }

    function it_has_client(Client $client)
    {
        $this->setClient($client)->getClient()->shouldReturn($client);
    }

    function it_has_an_available_restaurant(AvailableRestaurant $restaurant)
    {
        $this
            ->setAvailableRestaurant($restaurant)
            ->getAvailableRestaurant()
            ->shouldReturn($restaurant);
    }

    function it_is_unique_by_date(Client $client, AvailableRestaurant $restaurant)
    {
        $this
            ->setClient($client)
            ->setAvailableRestaurant($restaurant)
            ->getUniqueCriteria()
            ->shouldReturn([
                'client'              => $client,
                'availableRestaurant' => $restaurant,
            ]);
    }

    function it_is_json_serializable(Client $client, AvailableRestaurant $restaurant)
    {
        $this
            ->setId('foo')
            ->setClient($client)
            ->setAvailableRestaurant($restaurant)
            ->jsonSerialize()
            ->shouldReturn([
                'id'                  => 'foo',
                'client'              => $client,
                'availableRestaurant' => $restaurant,
            ]);
    }
}
