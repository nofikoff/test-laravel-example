<?php

namespace App\Services;

use App\DataTransferObjects\ActorData;
use App\Exceptions\ActorExtractionException;
use App\Exceptions\ActorValidationException;
use App\Exceptions\AIServiceException;
use App\Exceptions\DataTransformationException;
use App\Models\Actor;
use App\Services\Transformers\ActorDataTransformer;
use App\Services\Validators\ActorDataValidator;

class ActorService
{
    public function __construct(
        private readonly ActorExtractionService $extractionService,
        private readonly ActorDataValidator $validator,
        private readonly ActorDataTransformer $transformer
    ) {}

    public function createFromDescription(string $description, string $email, ?array $cachedData = null): Actor
    {
        $actorData = $this->extractActorData($description, $email, $cachedData);
        return Actor::create($actorData->toArray());
    }

    public function getAllActors(int $perPage = 15)
    {
        return Actor::latest()->paginate($perPage);
    }

    /**
     * Uses cached data if available to avoid duplicate AI calls.
     */
    private function extractActorData(string $description, string $email, ?array $cachedData = null): ActorData
    {
        try {
            $rawData = $cachedData ?? $this->extractionService->extractRawActorData($description);

            if ($cachedData === null) {
                $this->validator->validate($rawData);
            }

            $transformedData = $this->transformer->transform($rawData, $email);

            return ActorData::fromArray($transformedData);
        } catch (AIServiceException|ActorValidationException|DataTransformationException $e) {
            throw new ActorExtractionException(
                "Failed to extract actor data: {$e->getMessage()}",
                previous: $e
            );
        }
    }
}
