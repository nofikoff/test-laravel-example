<?php

namespace App\Services;

/**
 * Prevents duplicate AI API calls by caching extraction results
 * between validation and actor creation.
 */
class ActorDataCache
{
    private ?array $data = null;

    public function set(array $data): void
    {
        $this->data = $data;
    }

    public function get(): ?array
    {
        return $this->data;
    }

    public function has(): bool
    {
        return $this->data !== null;
    }

    public function clear(): void
    {
        $this->data = null;
    }
}
