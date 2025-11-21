<?php

namespace App\Services;

use App\Contracts\AIServiceInterface;
use App\Services\Transformers\ActorDataTransformer;

/**
 * Service for extracting actor information from natural language descriptions.
 *
 * Orchestrates the process of AI extraction and data transformation.
 * Validation is handled at the request level through Laravel validation rules.
 */
class ActorExtractionService
{
    /**
     * Create a new actor extraction service instance.
     *
     * @param AIServiceInterface $aiService Service for AI-powered data extraction
     * @param ActorDataTransformer $transformer Transformer for data format conversion
     */
    public function __construct(
        private readonly AIServiceInterface $aiService,
        private readonly ActorDataTransformer $transformer
    ) {}

    /**
     * Extract raw actor data from natural language description without transformation.
     *
     * Returns data in AI format (camelCase). Useful for validation purposes.
     *
     * @param string $description Natural language description of the actor
     * @return array<string, mixed> Raw extracted data in AI format
     *
     */
    public function extractRawActorData(string $description): array
    {
        $prompt = config('ai.actor_extraction_prompt');

        return $this->aiService->extractStructuredData($prompt, $description);
    }

    /**
     * Extract structured actor data from natural language description.
     *
     * Uses AI to parse the description and transforms the data into database-ready format.
     * Note: Validation should be performed separately before calling this method.
     *
     * @param string $description Natural language description of the actor
     * @return array<string, mixed> Extracted and transformed actor data
     *
     * @used-by \Tests\Unit\Services\ActorExtractionServiceTest
     */
    public function extractActorData(string $description): array
    {
        $rawData = $this->extractRawActorData($description);

        return $this->transformer->transform($rawData);
    }
}
