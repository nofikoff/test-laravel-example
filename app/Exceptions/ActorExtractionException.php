<?php

namespace App\Exceptions;

use Exception;

class ActorExtractionException extends Exception
{
    public function __construct(
        string $message = 'Failed to extract actor data',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
