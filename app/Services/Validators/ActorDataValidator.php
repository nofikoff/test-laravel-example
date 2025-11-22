<?php

namespace App\Services\Validators;

use App\Exceptions\ActorValidationException;

/**
 * Validator for actor data extracted from AI.
 *
 * Ensures that all required fields are present and non-empty
 * in the data returned by the AI service.
 */
class ActorDataValidator
{
    /** @var array<int, string> */
    private const REQUIRED_FIELDS = ['firstName', 'lastName', 'address'];

    /**
     * Validate that required actor fields are present in the data.
     *
     * @param array<string, mixed> $data The data to validate
     * @return void
     * @throws ActorValidationException If required fields are missing
     */
    public function validate(array $data): void
    {
        $missingFields = array_filter(
            self::REQUIRED_FIELDS,
            fn($field) => !isset($data[$field]) || empty($data[$field])
        );

        if (!empty($missingFields)) {
            throw ActorValidationException::missingRequiredFields($missingFields);
        }
    }

    /**
     * Get the list of required fields.
     *
     * @return array<int, string> List of required field names
     */
    public function getRequiredFields(): array
    {
        return self::REQUIRED_FIELDS;
    }
}

