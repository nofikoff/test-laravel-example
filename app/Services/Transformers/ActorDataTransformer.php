<?php

namespace App\Services\Transformers;

use App\Exceptions\DataTransformationException;

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
     * @param string $email Email from user input
     * @return array<string, mixed> The transformed data ready for database (snake_case format)
     * @throws DataTransformationException
     */
    public function transform(array $aiData, string $email): array
    {
        try {
            $this->validateRequiredFields($aiData);

            return [
                'first_name' => $aiData['firstName'],
                'last_name' => $aiData['lastName'],
                'address' => $aiData['address'],
                'email' => $email,
                'description' => $this->generateDescription($aiData),
                'height' => $aiData['height'] ?? null,
                'weight' => $aiData['weight'] ?? null,
                'gender' => $aiData['gender'] ?? null,
                'age' => $aiData['age'] ?? null,
            ];
        } catch (DataTransformationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new DataTransformationException(
                "Failed to transform actor data: {$e->getMessage()}",
                previous: $e
            );
        }
    }

    /**
     * Validate required fields are present.
     *
     * @param array<string, mixed> $data
     * @return void
     * @throws DataTransformationException
     */
    private function validateRequiredFields(array $data): void
    {
        if (!isset($data['firstName'])) {
            throw DataTransformationException::missingField('firstName');
        }

        if (!isset($data['lastName'])) {
            throw DataTransformationException::missingField('lastName');
        }

        if (!isset($data['address'])) {
            throw DataTransformationException::missingField('address');
        }
    }

    /**
     * Generate description from address.
     *
     * @param array<string, mixed> $data
     * @return string
     */
    private function generateDescription(array $data): string
    {
        $parts = [];

        if (isset($data['firstName']) && isset($data['lastName'])) {
            $parts[] = $data['firstName'] . ' ' . $data['lastName'];
        }

        if (isset($data['age'])) {
            $parts[] = $data['age'] . ' years old';
        }

        if (isset($data['gender'])) {
            $parts[] = $data['gender'];
        }

        if (isset($data['address'])) {
            $parts[] = 'lives at ' . $data['address'];
        }

        return !empty($parts) ? implode(', ', $parts) : '';
    }
}

