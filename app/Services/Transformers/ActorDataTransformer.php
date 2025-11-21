<?php

namespace App\Services\Transformers;

/**
 * Transformer for actor data from AI format to database format.
 *
 * Converts camelCase field names from AI response to snake_case
 * database column names and handles optional fields.
 */
class ActorDataTransformer
{
    /**
     * Transform AI response data to database format.
     *
     * Converts field names from camelCase (AI format) to snake_case (database format).
     * Optional fields default to null if not present in the AI response.
     *
     * @param array<string, mixed> $aiData The data from AI service (camelCase format)
     * @return array<string, mixed> The transformed data ready for database (snake_case format)
     */
    public function transform(array $aiData): array
    {
        return [
            'first_name' => $aiData['firstName'],
            'last_name' => $aiData['lastName'],
            'address' => $aiData['address'],
            'height' => $aiData['height'] ?? null,
            'weight' => $aiData['weight'] ?? null,
            'gender' => $aiData['gender'] ?? null,
            'age' => $aiData['age'] ?? null,
        ];
    }
}
