<?php

namespace App\Exceptions;

use Exception;

class ActorValidationException extends Exception
{
    public function __construct(
        string $message = 'Actor data validation failed',
        private readonly array $missingFields = [],
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getMissingFields(): array
    {
        return $this->missingFields;
    }

    public static function missingRequiredFields(array $fields): static
    {
        $message = 'Missing required fields: ' . implode(', ', $fields);

        return new static($message, $fields);
    }
}
