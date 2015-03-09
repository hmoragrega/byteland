<?php

namespace Byteland\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SwaggerController
 *
 * Return the json to feed swagger.
 *
 * @package Byteland\ApiBundle
 */
class SwaggerController extends Controller
{
    public function serveFeedAction()
    {
        return new Response(
            file_get_contents(__DIR__ . '/../Resources/doc/swagger.v1.json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}
