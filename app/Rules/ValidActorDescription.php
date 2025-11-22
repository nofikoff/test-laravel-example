<?php

namespace App\Rules;

use App\Exceptions\ActorExtractionException;
use App\Exceptions\ActorValidationException;
use App\Exceptions\AIServiceException;
use App\Exceptions\DataTransformationException;
use App\Services\ActorExtractionService;
use App\Services\Validators\ActorDataValidator;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validation rule for actor description.
 *
 * Validates that the description contains sufficient information
 * for AI to extract required actor fields without side effects.
 */
class ValidActorDescription implements ValidationRule
{
    public function __construct(
        private readonly ActorExtractionService $extractionService,
        private readonly ActorDataValidator $validator
    ) {}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $rawData = $this->extractionService->extractRawActorData($value);
            $this->validator->validate($rawData);
        } catch (ActorExtractionException|ActorValidationException|AIServiceException|DataTransformationException $e) {
            $fail($e->getMessage());
        }
    }
}
