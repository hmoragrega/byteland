<?php

namespace spec\Byteland\DomainBundle\Manager;

use Byteland\DomainBundle\Entity\ReserveList;
use Byteland\DomainBundle\Repository\MySQL\ReserveListRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ReserveListManagerSpec extends ObjectBehavior
{
    function let(RecursiveValidator $validator, ReserveListRepository $repository)
    {
        $this->beConstructedWith($validator, $repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Manager\ReserveListManager');
    }

    function it_is_an_available_restaurant_factory()
    {
        $this->factory()->shouldReturnAnInstanceOf('Byteland\DomainBundle\Entity\ReserveList');
    }

    function it_updates_the_reserve_list(ReserveList $reserveList)
    {
        $date = \DateTime::createFromFormat('Y-m-d', '2015-02-15');
        $reserveList->setDate($date)->shouldBeCalled();

        $this->update($reserveList, ['date' => '2015-02-15']);
    }
}
