<?php

namespace spec\Byteland\DomainBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RestaurantSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Entity\Restaurant');
    }

    // Trait testing HasId
    function it_has_an_id()
    {
        $this->setId('foo')->getId()->shouldBe('foo');
    }

    // Trait testing HasName
    function it_has_a_name()
    {
        $this->setName('foo')->getName()->shouldBe('foo');
    }

    function it_has_a_capacity()
    {
        $this->setCapacity(1)->getCapacity()->shouldBe(1);
    }

    function it_is_unique_by_name()
    {
        $this->setName('foo')->getUniqueCriteria()->shouldReturn(['name' => 'foo']);
    }

    function it_is_json_serializable()
    {
        $this->setCapacity(1)->setId('foo')->setName('bar')->jsonSerialize()->shouldReturn([
            'id'       => 'foo',
            'name'     => 'bar',
            'capacity' => 1,
        ]);
    }
}
