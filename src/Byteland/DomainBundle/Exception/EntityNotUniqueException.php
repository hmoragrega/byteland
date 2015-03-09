<?php

namespace Byteland\DomainBundle\Exception;

use Exception;
use DomainException;
use JsonSerializable;

/**
 * Exceptions used when the requested entity is not unique
 *
 * @package Byteland\DomainBundle
 */
class EntityNotUniqueException extends DomainException
    implements JsonSerializable
{
    /**
     * Exception code identifier.
     */
    const ID = 'entity_not_unique';

    /**
     * The criteria used to determine that the entity is not unique
     *
     * @var array
     */
    protected $criteria;

    /**
     * Constructor override
     *
     * @param array     $criteria
     * @param null      $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct(
        array $criteria,
        $message = null,
        $code = 0,
        Exception $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->criteria = $criteria;
    }

    /**
     * Returns the data ready to be encoded as json
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'error'            => $this->message,
            'error_id'         => self::ID,
            'duplicated_by'    => $this->criteria,
        ];
    }
}
