<?php

namespace spec\Byteland\DomainBundle\Manager;

use Byteland\DomainBundle\Entity\Client;
use Byteland\DomainBundle\Exception\ValidatorException;
use Byteland\DomainBundle\Repository\MySQL\ClientRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ClientManagerSpec extends ObjectBehavior
{
    function let(RecursiveValidator $validator, ClientRepository $repository)
    {
        $this->beConstructedWith($validator, $repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Manager\ClientManager');
    }

    function it_is_a_client_factory()
    {
        $this->factory()->shouldReturnAnInstanceOf('Byteland\DomainBundle\Entity\Client');
    }

    function it_updates_the_client_name(Client $client)
    {
        $client->setName('foo')->shouldBeCalled();
        $this->update($client, ['name' => 'foo']);
    }

    function it_saves_clients(
        RecursiveValidator $validator,
        ClientRepository $repository,
        Client $client,
        ConstraintViolationListInterface $violations
    ) {
        $violations->count()->willReturn(0);
        $validator->validate($client)->willReturn($violations);
        $repository->persist($client)->shouldBeCalled();

        $this->save($client);
    }

    function it_throws_a_validation_exception_if_entity_is_not_valid(
        RecursiveValidator $validator,
        Client $client,
        ConstraintViolationListInterface $violations
    ) {
        $violations->count()->willReturn(1);
        $validator->validate($client)->willReturn($violations);

        $this
            ->shouldThrow('\Byteland\DomainBundle\Exception\ValidatorException')
            ->during('validate', [$client]);
    }

    function it_finds_clients_by_given_criteria(ClientRepository $repository)
    {
        $repository->getSearchCriteria()->willReturn([]);
        $repository->findBy([])->shouldBeCalled();

        $this->findBy([]);
    }

    function it_throws_exception_when_the_criteria_given_is_not_valid(ClientRepository $repository)
    {
        $repository->getSearchCriteria()->willReturn([]);

        $this
            ->shouldThrow('\Byteland\DomainBundle\Exception\InvalidSearchCriteriaException')
            ->during('findBy', [['foo' => 'bar']]);
    }

    function it_finds_clients_by_their_id(ClientRepository $repository)
    {
        $repository->find('foo')->willReturn('foo');

        $this->find('foo');
    }

    function it_throws_exception_when_the_id_given_is_not_valid()
    {
        $this
            ->shouldThrow('\InvalidArgumentException')
            ->during('find', [null]);
    }

    function it_throws_exception_when_cannot_find_a_client_by_the_id(ClientRepository $repository)
    {
        $repository->find('foo')->willReturn(null);

        $this
            ->shouldThrow('\Byteland\DomainBundle\Exception\EntityNotFoundException')
            ->during('find', ['foo']);
    }

}
