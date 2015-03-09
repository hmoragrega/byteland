<?php

namespace Byteland\DomainBundle\Exception;

use RuntimeException;
use JsonSerializable;

/**
 * Exceptions used when the requested entity is not found
 *
 * @package Byteland\DomainBundle
 */
class EntityNotFoundException extends RuntimeException
    implements JsonSerializable
{
    /**
     * Exception code identifier.
     */
    const ID = 'entity_not_found';

    /**
     * Returns the data ready to be encoded as json
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'error'      => $this->message,
            'error_code' => self::ID
        ];
    }
}
