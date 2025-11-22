<?php

namespace App\Exceptions;

use Exception;

class AIServiceException extends Exception
{
    /**
     * Create a new exception instance for AI service failures.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'AI service request failed',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Create exception for API timeout.
     *
     * @return static
     */
    public static function timeout(): static
    {
        return new static('AI service request timed out');
    }

    /**
     * Create exception for invalid response.
     *
     * @return static
     */
    public static function invalidResponse(): static
    {
        return new static('AI service returned invalid response');
    }

    /**
     * Create exception for API error.
     *
     * @param string $message
     * @return static
     */
    public static function apiError(string $message): static
    {
        return new static("AI service API error: {$message}");
    }
}
