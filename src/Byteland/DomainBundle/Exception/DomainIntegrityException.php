<?php

namespace Byteland\DomainBundle\Exception;

use DomainException;
use JsonSerializable;

/**
 * Exceptions used to notify the violation of a foreign key
 *
 * @package Byteland\DomainBundle
 */
class DomainIntegrityException extends DomainException
    implements JsonSerializable
{
    /**
     * Exception code identifier.
     */
    const ID = 'foreign_key_violation';

    /**
     * Returns the data ready to be encoded as json
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'error'    => $this->message,
            'error_id' => self::ID
        ];
    }
}
