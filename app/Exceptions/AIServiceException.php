<?php

namespace App\Exceptions;

use Exception;

class AIServiceException extends Exception
{
    public function __construct(
        string $message = 'AI service request failed',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function timeout(): static
    {
        return new static('AI service request timed out');
    }

    public static function invalidResponse(): static
    {
        return new static('AI service returned invalid response');
    }

    public static function apiError(string $message): static
    {
        return new static("AI service API error: {$message}");
    }
}
