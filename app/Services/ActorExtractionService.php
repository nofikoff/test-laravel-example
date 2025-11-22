<?php

namespace App\Services;

use App\Contracts\AIServiceInterface;
use App\Services\Transformers\ActorDataTransformer;

class ActorExtractionService
{
    public function __construct(
        private readonly AIServiceInterface $aiService,
        private readonly ActorDataTransformer $transformer
    ) {}

    public function extractRawActorData(string $description): array
    {
        return $this->aiService->extractStructuredData(
            config('ai.actor_extraction_prompt'),
            $description
        );
    }

    public function extractActorData(string $description, string $email): array
    {
        $rawData = $this->extractRawActorData($description);
        return $this->transformer->transform($rawData, $email);
    }
}
