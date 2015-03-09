<?php

namespace Byteland\DomainBundle\Exception;

use Exception;
use JsonSerializable;
use DomainException;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Exceptions used to pass the list of validation errors
 *
 * @package Byteland\DomainBundle
 */
class ValidatorException extends DomainException implements JsonSerializable
{
    /**
     * Exception code identifier.
     */
    const ID = 'validator_exception';

    /**
     * List of validation violations
     *
     * @var array
     */
    protected $violationList = [];

    /**
     * Constructor
     *
     * @param array       $violationList
     * @param string|null $message
     * @param int         $code
     * @param Exception   $previous
     */
    public function __construct(
        $violationList = [],
        $message = null,
        $code = 0,
        Exception $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->violationList = $violationList;
    }

    /**
     * Get the validation errors
     *
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->violationList;
    }

    /**
     * Serializes the exception
     */
    function jsonSerialize ()
    {
        $errors = [];
        foreach ($this->violationList as $key => $violation) {
            if ($violation instanceof ConstraintViolationInterface) {
                die("1");
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            } else {
                $errors[$key] = $violation;
            }
        }

        return [
            'error'             => $this->message,
            'error_id'          => self::ID,
            'validation_errors' => $errors,
        ];
    }
}
