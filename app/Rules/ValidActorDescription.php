<?php

namespace App\Rules;

use App\Exceptions\ActorExtractionException;
use App\Exceptions\ActorValidationException;
use App\Exceptions\AIServiceException;
use App\Exceptions\DataTransformationException;
use App\Services\ActorDataCache;
use App\Services\ActorExtractionService;
use App\Services\Validators\ActorDataValidator;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidActorDescription implements ValidationRule
{
    public function __construct(
        private readonly ActorExtractionService $extractionService,
        private readonly ActorDataValidator $validator,
        private readonly ActorDataCache $cache
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $rawData = $this->extractionService->extractRawActorData($value);
            $this->validator->validate($rawData);
            $this->cache->set($rawData);
        } catch (ActorExtractionException|ActorValidationException|AIServiceException|DataTransformationException $e) {
            $fail($e->getMessage());
        }
    }
}
