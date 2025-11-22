<?php

namespace App\Services\Validators;

use App\Exceptions\ActorValidationException;

class ActorDataValidator
{
    private const REQUIRED_FIELDS = ['firstName', 'lastName', 'address'];

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

    public function getRequiredFields(): array
    {
        return self::REQUIRED_FIELDS;
    }
}

