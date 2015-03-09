<?php

namespace spec\Byteland\DomainBundle\Repository\MySQL;

use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ReserveRepositorySpec extends ObjectBehavior
{
    protected $repo;

    function let(EntityManager $entityManager, EntityRepository $repository)
    {
        $this->beConstructedWith($entityManager, 'Reserve');
        $entityManager->getRepository('Reserve')->willReturn($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Repository\MySQL\ReserveRepository');
    }

    function it_defines_the_allowed_search_criteria()
    {
        $criteria = $this->getSearchCriteria();
        $criteria->shouldHaveKey('client');
        $criteria->shouldHaveKey('availableRestaurant');
    }
}
