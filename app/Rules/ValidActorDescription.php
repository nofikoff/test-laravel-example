<?php

namespace App\Rules;

use App\Services\ActorExtractionService;
use App\Services\Validators\ActorDataValidator;
use App\Services\Transformers\ActorDataTransformer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validation rule for actor description that can be extracted by AI.
 *
 * Validates that the description contains sufficient information
 * for AI to extract required actor fields (firstName, lastName, address).
 */
class ValidActorDescription implements ValidationRule
{
    private ?array $extractedData = null;

    public function __construct(
        private readonly ActorExtractionService $extractionService,
        private readonly ActorDataValidator $validator,
        private readonly ActorDataTransformer $transformer
    ) {}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $rawData = $this->extractionService->extractRawActorData($value);

            $this->validator->validate($rawData);

            $this->extractedData = $this->transformer->transform($rawData);
        } catch (\Exception $e) {
            $fail($e->getMessage());
        }
    }

    /**
     * Get the extracted actor data after successful validation.
     *
     * @return array<string, mixed>|null
     */
    public function getExtractedData(): ?array
    {
        return $this->extractedData;
    }
}
