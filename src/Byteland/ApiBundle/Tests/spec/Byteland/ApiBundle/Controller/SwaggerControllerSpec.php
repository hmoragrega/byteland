<?php

namespace spec\Byteland\ApiBundle\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Test fot the swagger controller
 *
 * @packege Byteland\ApiBundle
 */
class SwaggerControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\ApiBundle\Controller\SwaggerController');
    }

    function it_returns_a_valid_swagger_json_schema()
    {
        $response = $this->serveFeedAction();
        $response->shouldReturnAnInstanceOf('\Symfony\Component\HttpFoundation\Response');

        $response->getContent()->shouldBeString();
        $response->shouldBeOk();
        $response->headers->all()->shouldHaveKey('content-type');
        $response->headers->get('content-type')->shouldBe('application/json');
    }
}
