<?php

namespace App\Services;

use App\DataTransferObjects\ActorData;
use App\Exceptions\ActorExtractionException;
use App\Models\Actor;
use App\Services\Transformers\ActorDataTransformer;
use App\Services\Validators\ActorDataValidator;

/**
 * Service for handling actor business logic.
 */
class ActorService
{
    public function __construct(
        private readonly ActorExtractionService $extractionService,
        private readonly ActorDataValidator $validator,
        private readonly ActorDataTransformer $transformer
    ) {}

    /**
     * Create actor from description and email.
     *
     * @param string $description
     * @param string $email
     * @return Actor
     * @throws ActorExtractionException
     */
    public function createFromDescription(string $description, string $email): Actor
    {
        $actorData = $this->extractActorData($description, $email);

        return Actor::create($actorData->toArray());
    }

    /**
     * Extract and validate actor data from description.
     *
     * @param string $description
     * @param string $email
     * @return ActorData
     * @throws ActorExtractionException
     */
    public function extractActorData(string $description, string $email): ActorData
    {
        try {
            $rawData = $this->extractionService->extractRawActorData($description);
            $this->validator->validate($rawData);
            $transformedData = $this->transformer->transform($rawData, $email);

            return ActorData::fromArray($transformedData);
        } catch (\Exception $e) {
            throw new ActorExtractionException(
                "Failed to extract actor data: {$e->getMessage()}",
                previous: $e
            );
        }
    }
}
