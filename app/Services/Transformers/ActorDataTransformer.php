<?php

namespace App\Services\Transformers;

use App\Exceptions\DataTransformationException;

/**
 * Converts AI response (camelCase) to database format (snake_case).
 */
class ActorDataTransformer
{
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

