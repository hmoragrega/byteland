<?php

namespace spec\Byteland\DomainBundle\Entity;

use DateTime;
use PhpSpec\ObjectBehavior;

class ReserveListSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Entity\ReserveList');
    }

    // Trait testing HasId
    function it_has_an_id()
    {
        $this->setId('foo')->getId()->shouldBe('foo');
    }

    function it_has_a_date()
    {
        $date = new DateTime();
        $this->setDate($date)->getDate()->shouldBe($date);
    }

    function it_is_unique_by_date()
    {
        $date = new DateTime();
        $this->setDate($date)->getUniqueCriteria()->shouldReturn(
            ['date' => $date]
        );
    }

    function it_is_json_serializable()
    {
        $date = new DateTime();
        $this
            ->setId('foo')
            ->setDate($date)
            ->setAvailableRestaurants([1 => 'bar', 5 => 'doe'])
            ->jsonSerialize()
            ->shouldReturn([
                'id'                   => 'foo',
                'date'                 => $date->format('Y-m-d'),
                'availableRestaurants' => [1, 5],
            ]);
    }
}
