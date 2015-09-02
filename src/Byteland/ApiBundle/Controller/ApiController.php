<?php

namespace Byteland\ApiBundle\Controller;

use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Byteland\DomainBundle\Manager\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Byteland\DomainBundle\Exception\ValidatorException;
use Byteland\DomainBundle\Exception\EntityNotFoundException;
use Byteland\DomainBundle\Exception\DomainIntegrityException;
use Byteland\DomainBundle\Exception\EntityNotUniqueException;
use Byteland\DomainBundle\Exception\InvalidSearchCriteriaException;

/**
 * Controller with the api methods
 *
 * @package Byteland\ApiBundle
 */
class ApiController
{
    /**
     * The entity manager
     *
     * @var EntityManager
     */
    protected $manager;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->manager = $entityManager;
    }

    /**
     * Finds an entity by the id
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function find($id)
    {
        try {
            $entity = $this->manager->find($id);

        } catch (EntityNotFoundException $exception) {

            return $this->json($exception, JsonResponse::HTTP_NOT_FOUND);

        } catch (InvalidArgumentException $exception) {

            return $this->json($exception, JsonResponse::HTTP_BAD_REQUEST);

        } catch (Exception $exception) {
            return $this->serverError($exception);
        }

        return $this->json($entity);
    }

    /**
     * Handles the listing of entities
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function findBy(Request $request)
    {
        try {
            $criteria = $request->query->all();
            $entities = $this->manager->findBy($criteria);

        } catch (InvalidSearchCriteriaException $exception) {
            return $this->json($exception, JsonResponse::HTTP_BAD_REQUEST);

        } catch (Exception $exception) {
            return $this->serverError($exception);
        }

        return $this->json($entities);
    }

    /**
     * Creates a new restaurant
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $entity = $this->manager->factory($request->request->all());
            $this->manager->save($entity);

        } catch (ValidatorException $exception) {
            return $this->json($exception, JsonResponse::HTTP_BAD_REQUEST);

        } catch (EntityNotUniqueException $exception) {
            return $this->json($exception, JsonResponse::HTTP_FORBIDDEN);

        } catch (Exception $exception) {
            return $this->serverError($exception);
        }

        return $this->json($entity, JsonResponse::HTTP_CREATED);
    }

    /**
     * Deletes a restaurant
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $this->manager->deleteById($id);

        } catch (DomainIntegrityException $exception) {
            return $this->json($exception, JsonResponse::HTTP_FORBIDDEN);

        } catch (Exception $exception) {
            return $this->serverError($exception);
        }

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Update a restaurant
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $entity = $this->manager->update(
                $this->manager->find($id),
                $request->request->all()
            );

            $this->manager->save($entity);

        } catch (EntityNotFoundException $exception) {
            return $this->json($exception, JsonResponse::HTTP_NOT_FOUND);

        } catch (ValidatorException $exception) {
            return $this->json($exception, JsonResponse::HTTP_BAD_REQUEST);

        } catch (EntityNotUniqueException $exception) {
            return $this->json($exception, JsonResponse::HTTP_FORBIDDEN);

        } catch (Exception $exception) {
            return $this->serverError($exception);
        }

        return $this->json($entity, JsonResponse::HTTP_OK);
    }

    /**
     * Returns the json response
     *
     * @param mixed $data
     * @param int $code
     *
     * @return JsonResponse
     */
    protected function json($data, $code = JsonResponse::HTTP_OK)
    {
        return new JsonResponse($data, $code);
    }

    /**
     * Returns a json with a server error message
     *
     * @param Exception $exception
     *
     * @return JsonResponse
     */
    protected function serverError(Exception $exception)
    {
        $data = [
            'error'      => $exception->getMessage(),
            'exception'  => get_class($exception),
        ];

        return $this->json($data, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}