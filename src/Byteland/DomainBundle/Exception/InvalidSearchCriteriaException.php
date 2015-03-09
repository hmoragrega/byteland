<?php

namespace Byteland\DomainBundle\Exception;

use Exception;
use DomainException;
use JsonSerializable;

/**
 * Exceptions used when the search filters are not allowed
 *
 * @package Byteland\DomainBundle
 * @subpackage Domain
 */
class InvalidSearchCriteriaException extends DomainException
    implements JsonSerializable
{
    /**
     * Exception code identifier.
     */
    const ID = 'invalid_search_criteria';

    /**
     * The invalid filters detected
     *
     * @var array
     */
    protected $invalidCriteria;

    /**
     * The only allowed filters
     *
     * @var array
     */
    protected $allowedCriteria;

    /**
     * Constructor override
     *
     * @param array     $invalidCriteria
     * @param null      $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct(
        array $invalidCriteria,
        array $allowedCriteria = [],
        $message = null,
        $code = 0,
        Exception $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->invalidCriteria = $invalidCriteria;
        $this->allowedCriteria = $allowedCriteria;
    }

    /**
     * Get the invalid filters detected
     *
     * @return array
     */
    public function getInvalidCriteria()
    {
        return $this->invalidCriteria;
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
            'invalid_criteria' => $this->invalidCriteria,
            'allowed_criteria' => $this->allowedCriteria,
        ];
    }
}
