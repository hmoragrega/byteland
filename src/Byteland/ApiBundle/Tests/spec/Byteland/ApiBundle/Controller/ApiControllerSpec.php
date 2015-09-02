<?php

namespace spec\Byteland\ApiBundle\Controller;

use Byteland\DomainBundle\Entity\Entity;
use PhpSpec\ObjectBehavior;
use Byteland\DomainBundle\Manager\EntityManager;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Spec tests for the api controller
 *
 * @package Byteland\ApiBundle
 */
class ApiControllerSpec extends ObjectBehavior
{
    function let(EntityManager $manager)
    {
        $this->beConstructedWith($manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\ApiBundle\Controller\ApiController');
    }

    function it_finds_an_entity_by_the_id($manager)
    {
        $manager->find('foo')->willReturn('foo');
        
        
        
        
        
        
        $response = $this->find('foo');

        $this->validateJsonResponse($response, Response::HTTP_OK, 'foo');
    }

    function it_finds_entities($manager, Request $request, ParameterBag $query)
    {
        $request->query = $query;
        $query->all()->willReturn(['bar']);
        $manager->findBy(['bar'])->willReturn('entity');
        $response = $this->findBy($request);

        $this->validateJsonReponse($response, Response::HTTP_OK, 'entity');
    }

    function it_create_entities($manager, Request $request, ParameterBag $requestParams, Entity $entity)
    {
        $request->request = $requestParams;
        $requestParams->all()->willReturn(['bar']);
        $manager->factory(['bar'])->willReturn($entity);
        $manager->save($entity)->shouldBeCalled();
        $response = $this->create($request);

        $this->validateJsonReponse($response, Response::HTTP_CREATED);
    }

    function it_deletes_an_entity_by_the_id($manager)
    {
        $manager->deleteById('foo')->willReturn('foo');
        $response = $this->delete('foo');

        $this->validateJsonReponse($response, Response::HTTP_NO_CONTENT, '');
    }

    function it_updates_entities($manager, Request $request, ParameterBag $requestParams, Entity $entity)
    {
        $request->request = $requestParams;
        $requestParams->all()->willReturn(['bar']);
        $manager->find('foo')->willReturn($entity);
        $manager->update($entity, ['bar'])->willReturn($entity);
        $manager->save($entity)->shouldBeCalled();
        $response = $this->update($request, 'foo');

        $this->validateJsonReponse($response, Response::HTTP_OK);
    }

    function it_throws_exception_when_the_entity_is_missing($manager)
    {
        $manager->find('foo')->willThrow('Byteland\DomainBundle\Exception\EntityNotFoundException');
        $response = $this->find('foo');

        $this->validateJsonReponse($response, Response::HTTP_NOT_FOUND);
    }

    function it_throws_exception_when_the_entity_is_invalid($manager)
    {
        $manager->find('foo')->willThrow('InvalidArgumentException');
        $response = $this->find('foo');

        $this->validateJsonReponse($response, Response::HTTP_BAD_REQUEST);
    }

    function it_throws_exception_when_there_is_an_unkown_error($manager)
    {
        $manager->find('foo')->willThrow(new \Exception('foo'));
        $response = $this->find('foo');

        $this->validateJsonReponse($response, Response::HTTP_INTERNAL_SERVER_ERROR,[
            'error'     => 'foo',
            'exception' => 'Exception'
        ]);
    }

    function it_throws_exception_when_searching_with_invalid_criteria(
        Request $request,
        ParameterBag $query
    ) {
        $query->all()->willThrow('Byteland\DomainBundle\Exception\InvalidSearchCriteriaException');
        $request->query = $query;
        $response = $this->findBy($request);

        $this->validateJsonReponse($response, Response::HTTP_BAD_REQUEST);
    }

    function it_throws_exception_when_saving_invalid_entities(
        Request $request,
        ParameterBag $query
    ) {
        $query->all()->willThrow('Byteland\DomainBundle\Exception\ValidatorException');
        $request->request = $query;
        $response = $this->create($request);

        $this->validateJsonReponse($response, Response::HTTP_BAD_REQUEST);
    }

    function it_throws_exception_when_saving_a_duplicate_entity(
        Request $request,
        ParameterBag $query
    ) {
        $query->all()->willThrow('Byteland\DomainBundle\Exception\EntityNotUniqueException');
        $request->request = $query;
        $response = $this->create($request);

        $this->validateJsonReponse($response, Response::HTTP_FORBIDDEN);
    }

    function it_throws_exception_when_deleting_an_entity_with_relationship($manager)
    {
        $manager->deleteById('foo')->willThrow('Byteland\DomainBundle\Exception\DomainIntegrityException');
        $response = $this->delete('foo');

        $this->validateJsonReponse($response, Response::HTTP_FORBIDDEN);
    }

    function it_throws_exception_when_updating_a_non_existant_entity(
        Request $request,
        ParameterBag $query
    ) {
        $query->all()->willThrow('Byteland\DomainBundle\Exception\EntityNotFoundException');
        $request->request = $query;
        $response = $this->update($request, 'foo');

        $this->validateJsonReponse($response, Response::HTTP_NOT_FOUND);
    }

    function it_throws_exception_when_updating_a_non_valid_entity(
        Request $request,
        ParameterBag $query
    ) {
        $query->all()->willThrow('Byteland\DomainBundle\Exception\ValidatorException');
        $request->request = $query;
        $response = $this->update($request, 'foo');

        $this->validateJsonReponse($response, Response::HTTP_BAD_REQUEST);
    }

    function it_throws_exception_when_updating_a_duplicate_entity(
        Request $request,
        ParameterBag $query
    ) {
        $query->all()->willThrow('Byteland\DomainBundle\Exception\EntityNotUniqueException');
        $request->request = $query;
        $response = $this->update($request, 'foo');

        $this->validateJsonReponse($response, Response::HTTP_FORBIDDEN);
    }

    protected function validateJsonReponse($response, $code, $data = null)
    {
        $response->getStatusCode()->shouldBe($code);
        $response->headers->all()->shouldHaveKey('content-type');
        $response->headers->get('content-type')->shouldBe('application/json');

        if ($data) {
            $response->getContent()->shouldBeLike(json_encode($data));
        }

    }
}
