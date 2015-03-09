<?php

namespace spec\Byteland\DomainBundle\Exception;

use PhpSpec\ObjectBehavior;

class ValidatorExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['foo'], 'Message');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Exception\ValidatorException');
    }

    function it_is_json_serializable()
    {
        $this->jsonSerialize()->shouldReturn([
            'error'             => 'Message',
            'error_id'          => 'validator_exception',
            'validation_errors' => ['foo'],
        ]);
    }
}
