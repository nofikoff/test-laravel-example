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

        $result = $this->transformer->transform($aiData, 'john@example.com');

        $this->assertEquals('John', $result['first_name']);
        $this->assertEquals('Doe', $result['last_name']);
        $this->assertEquals('123 Main St', $result['address']);
        $this->assertEquals('180cm', $result['height']);
        $this->assertEquals('75kg', $result['weight']);
        $this->assertEquals('male', $result['gender']);
        $this->assertEquals(30, $result['age']);
        $this->assertEquals('john@example.com', $result['email']);
        $this->assertStringContainsString('John Doe', $result['description']);
    }

    public function test_transforms_required_fields_only(): void
    {
        $aiData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'address' => '123 Main St',
        ];

        $result = $this->transformer->transform($aiData, 'test@example.com');

        $this->assertEquals('John', $result['first_name']);
        $this->assertEquals('Doe', $result['last_name']);
        $this->assertEquals('123 Main St', $result['address']);
        $this->assertEquals('test@example.com', $result['email']);
        $this->assertNull($result['height']);
        $this->assertNull($result['weight']);
        $this->assertNull($result['gender']);
        $this->assertNull($result['age']);
    }

    public function test_sets_null_for_missing_optional_fields(): void
    {
        $aiData = [
            'firstName' => 'Jane',
            'lastName' => 'Smith',
            'address' => '456 Oak Ave',
            'height' => '165cm',
        ];

        $result = $this->transformer->transform($aiData, 'jane@example.com');

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

        $result = $this->transformer->transform($aiData, 'test@example.com');

        $this->assertArrayHasKey('first_name', $result);
        $this->assertArrayHasKey('last_name', $result);
        $this->assertArrayNotHasKey('firstName', $result);
        $this->assertArrayNotHasKey('lastName', $result);
    }

    public function test_generates_description_from_data(): void
    {
        $aiData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'address' => '123 Main St',
            'height' => '180cm',
            'weight' => '75kg',
            'age' => 30,
            'gender' => 'male',
        ];

        $result = $this->transformer->transform($aiData, 'john@example.com');

        $this->assertStringContainsString('John Doe', $result['description']);
        $this->assertStringContainsString('30 years old', $result['description']);
        $this->assertStringContainsString('male', $result['description']);
        $this->assertStringContainsString('123 Main St', $result['description']);
    }
}
