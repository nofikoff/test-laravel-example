<?php

namespace App\Exceptions;

use Exception;

class DataTransformationException extends Exception
{
    public function __construct(
        string $message = 'Data transformation failed',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function missingField(string $field): static
    {
        return new static("Required field '{$field}' is missing in source data");
    }
}
