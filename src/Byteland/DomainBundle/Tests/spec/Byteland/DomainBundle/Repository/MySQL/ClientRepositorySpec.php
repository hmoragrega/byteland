<?php

namespace spec\Byteland\DomainBundle\Repository\MySQL;

use Byteland\DomainBundle\Entity\Client;
use Doctrine\DBAL\DBALException;
use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Byteland\DomainBundle\Exception\EntityNotUniqueException;

class ClientRepositorySpec extends ObjectBehavior
{
    protected $repo;

    function let(EntityManager $entityManager, EntityRepository $repository)
    {
        $this->beConstructedWith($entityManager, 'Client');
        $entityManager->getRepository('Client')->willReturn($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Repository\MySQL\ClientRepository');
    }

    function it_finds_clients_by_valid_criteria($repository)
    {
        $criteria = ['foo'];
        $repository->findBy($criteria)->shouldBeCalled();
        $this->findBy($criteria);
    }

    function it_finds_clients_by_the_id($repository)
    {
        $id = 'foo';
        $repository->find($id)->shouldBeCalled();
        $this->find($id);
    }

    function it_persists_clients($entityManager, Client $client)
    {
        $entityManager->persist($client)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->persist($client);
    }

    function it_should_throw_an_exeception_if_client_already_exists_on_persist(
        $entityManager,
        $repository,
        Client $client,
        Client $duplicate
    ) {
        $entityManager->persist($client)->willThrow('Doctrine\DBAL\DBALException');
        $repository->findOneBy(['criteria'])->willReturn($duplicate);
        $client->getUniqueCriteria()->willReturn(['criteria']);

        $client->getId()->willReturn(1);
        $duplicate->getId()->willReturn(2);

        $this
            ->shouldThrow('Byteland\DomainBundle\Exception\EntityNotUniqueException')
            ->during('persist', [$client]);
    }

    function it_removes_clients($entityManager, Client $client)
    {
        $entityManager->remove($client)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->remove($client);
    }

    function it_removes_clients_by_the_id($entityManager, Client $client)
    {
        $entityManager->getPartialReference('Client', ['id' => 'foo'])->willReturn($client);
        $entityManager->remove($client)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->removeById('foo');
    }

    function it_should_throw_an_exeception_if_deletion_is_restricted_by_foreign_key(
        $entityManager,
        Client $client
    ) {
        $entityManager
            ->remove($client)
            ->willThrow(new DBALException('Error: Integrity constraint violation.'));

        $this
            ->shouldThrow('Byteland\DomainBundle\Exception\DomainIntegrityException')
            ->during('remove', [$client]);
    }

    function it_defines_the_allowed_search_criteria()
    {
        $this->getSearchCriteria()->shouldHaveKey('name');
    }
}
