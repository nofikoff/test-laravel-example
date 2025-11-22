<?php

namespace App\Exceptions;

use Exception;

class ActorValidationException extends Exception
{
    /**
     * Create a new exception instance for validation failure.
     *
     * @param string $message
     * @param array<string, mixed> $missingFields
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'Actor data validation failed',
        private readonly array $missingFields = [],
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get missing fields.
     *
     * @return array<string, mixed>
     */
    public function getMissingFields(): array
    {
        return $this->missingFields;
    }

    /**
     * Create exception for missing required fields.
     *
     * @param array<string> $fields
     * @return static
     */
    public static function missingRequiredFields(array $fields): static
    {
        $message = 'Missing required fields: ' . implode(', ', $fields);

        return new static($message, $fields);
    }
}
