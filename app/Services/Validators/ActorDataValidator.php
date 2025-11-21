<?php

namespace App\Services\Validators;

/**
 * Validator for actor data extracted from AI.
 *
 * Ensures that all required fields are present and non-empty
 * in the data returned by the AI service.
 */
class ActorDataValidator
{
    /**
     * Validate that required actor fields are present in the data.
     *
     * @param array<string, mixed> $data The data to validate
     * @return void
     * @throws \Exception If required fields are missing
     */
    public function validate(array $data): void
    {
        $requiredFields = ['firstName', 'lastName', 'address'];

        $missingFields = array_filter(
            $requiredFields,
            fn($field) => !isset($data[$field]) || empty($data[$field])
        );

        if (!empty($missingFields)) {
            throw new \Exception(__('messages.missing_required_fields'));
        }
    }

    /**
     * Get the list of required fields.
     *
     * @return array<int, string> List of required field names
     */
    public function getRequiredFields(): array
    {
        return ['firstName', 'lastName', 'address'];
    }
}
