<?php

namespace Tests\Unit\Services\Transformers;

use App\Services\Transformers\ActorDataTransformer;
use PHPUnit\Framework\TestCase;

class ActorDataTransformerTest extends TestCase
{
    private ActorDataTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new ActorDataTransformer();
    }

    public function test_transforms_all_fields_correctly(): void
    {
        $aiData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'address' => '123 Main St',
            'height' => '180cm',
            'weight' => '75kg',
            'gender' => 'male',
            'age' => 30,
        ];

        $result = $this->transformer->transform($aiData);

        $this->assertEquals([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => '123 Main St',
            'height' => '180cm',
            'weight' => '75kg',
            'gender' => 'male',
            'age' => 30,
        ], $result);
    }

    public function test_transforms_required_fields_only(): void
    {
        $aiData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'address' => '123 Main St',
        ];

        $result = $this->transformer->transform($aiData);

        $this->assertEquals([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => '123 Main St',
            'height' => null,
            'weight' => null,
            'gender' => null,
            'age' => null,
        ], $result);
    }

    public function test_sets_null_for_missing_optional_fields(): void
    {
        $aiData = [
            'firstName' => 'Jane',
            'lastName' => 'Smith',
            'address' => '456 Oak Ave',
            'height' => '165cm',
        ];

        $result = $this->transformer->transform($aiData);

        $this->assertNull($result['weight']);
        $this->assertNull($result['gender']);
        $this->assertNull($result['age']);
        $this->assertEquals('165cm', $result['height']);
    }

    public function test_converts_camel_case_to_snake_case(): void
    {
        $aiData = [
            'firstName' => 'Test',
            'lastName' => 'User',
            'address' => 'Test Address',
        ];

        $result = $this->transformer->transform($aiData);

        $this->assertArrayHasKey('first_name', $result);
        $this->assertArrayHasKey('last_name', $result);
        $this->assertArrayNotHasKey('firstName', $result);
        $this->assertArrayNotHasKey('lastName', $result);
    }

    public function test_preserves_data_types(): void
    {
        $aiData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'address' => '123 Main St',
            'age' => 30,
        ];

        $result = $this->transformer->transform($aiData);

        $this->assertIsString($result['first_name']);
        $this->assertIsInt($result['age']);
    }
}
