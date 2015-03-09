<?php

namespace spec\Byteland\DomainBundle\Exception;

use PhpSpec\ObjectBehavior;

class DomainIntegrityExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Message');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Byteland\DomainBundle\Exception\DomainIntegrityException');
    }

    function it_is_json_serializable()
    {
        $this->jsonSerialize()->shouldReturn([
            'error'    => 'Message',
            'error_id' => 'foreign_key_violation',
        ]);
    }
}
