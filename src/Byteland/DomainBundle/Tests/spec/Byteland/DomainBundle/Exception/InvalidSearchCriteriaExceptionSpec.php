<?php

namespace spec\Byteland\DomainBundle\Exception;

use PhpSpec\ObjectBehavior;

class InvalidSearchCriteriaExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['foo'], ['bar'], 'Message');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Exception\InvalidSearchCriteriaException');
    }

    function it_is_json_serializable()
    {
        $this->jsonSerialize()->shouldReturn([
            'error'            => 'Message',
            'error_id'         => 'invalid_search_criteria',
            'invalid_criteria' => ['foo'],
            'allowed_criteria' => ['bar'],
        ]);
    }
}
