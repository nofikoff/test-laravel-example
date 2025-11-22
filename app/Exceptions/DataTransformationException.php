<?php

namespace App\Exceptions;

use Exception;

class DataTransformationException extends Exception
{
    /**
     * Create a new exception instance for transformation failure.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'Data transformation failed',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Create exception for missing field.
     *
     * @param string $field
     * @return static
     */
    public static function missingField(string $field): static
    {
        return new static("Required field '{$field}' is missing in source data");
    }
}
