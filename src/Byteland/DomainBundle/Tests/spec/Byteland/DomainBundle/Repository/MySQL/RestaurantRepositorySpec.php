<?php

namespace spec\Byteland\DomainBundle\Repository\MySQL;

use Doctrine\ORM\Query;
use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class RestaurantRepositorySpec extends ObjectBehavior
{
    protected $repo;

    function let(EntityManager $entityManager, EntityRepository $repository)
    {
        $this->beConstructedWith($entityManager, 'Restaurant');
        $entityManager->getRepository('Restaurant')->willReturn($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Repository\MySQL\RestaurantRepository');
    }

    function it_defines_the_allowed_search_criteria()
    {
        $criteria = $this->getSearchCriteria();
        $criteria->shouldHaveKey('name');
        $criteria->shouldHaveKey('capacity');
    }
}
