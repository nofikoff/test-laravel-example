<?php

namespace App\DataTransferObjects;

class ActorData
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $address,
        public readonly string $email,
        public readonly string $description,
        public readonly ?int $age = null,
        public readonly ?string $gender = null,
        public readonly ?string $height = null,
        public readonly ?string $weight = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            address: $data['address'],
            email: $data['email'],
            description: $data['description'],
            age: $data['age'] ?? null,
            gender: $data['gender'] ?? null,
            height: $data['height'] ?? null,
            weight: $data['weight'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'address' => $this->address,
            'email' => $this->email,
            'description' => $this->description,
            'age' => $this->age,
            'gender' => $this->gender,
            'height' => $this->height,
            'weight' => $this->weight,
        ];
    }
}
