<?php

namespace spec\Byteland\DomainBundle\Exception;

use PhpSpec\ObjectBehavior;

class EntityNotUniqueExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['foo'], 'Message');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Exception\EntityNotUniqueException');
    }

    function it_is_json_serializable()
    {
        $this->jsonSerialize()->shouldReturn([
            'error'         => 'Message',
            'error_id'      => 'entity_not_unique',
            'duplicated_by' => ['foo'],
        ]);
    }
}
