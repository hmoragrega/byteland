<?php

namespace spec\Byteland\DomainBundle\Repository\MySQL;

use Doctrine\ORM\Query;
use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AvailableRestaurantRepositorySpec extends ObjectBehavior
{
    protected $repo;

    function let(EntityManager $entityManager, EntityRepository $repository)
    {
        $this->beConstructedWith($entityManager, 'AvailableRestaurant');
        $entityManager->getRepository('AvailableRestaurant')->willReturn($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Repository\MySQL\AvailableRestaurantRepository');
    }

    function it_defines_the_allowed_search_criteria()
    {
        $criteria = $this->getSearchCriteria();
        $criteria->shouldHaveKey('restaurant');
        $criteria->shouldHaveKey('reserveList');
    }
}
