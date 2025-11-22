<?php

namespace App\Exceptions;

use Exception;

class ActorExtractionException extends Exception
{
    /**
     * Create a new exception instance for extraction failure.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'Failed to extract actor data',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
