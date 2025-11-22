<?php

namespace App\Exceptions;

use Exception;

class ActorValidationException extends Exception
{
    public static function missingRequiredFields(array $fields): static
    {
        $message = 'Missing required fields: ' . implode(', ', $fields);

        return new static($message);
    }
}
