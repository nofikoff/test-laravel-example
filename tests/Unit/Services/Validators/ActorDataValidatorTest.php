<?php

namespace Tests\Unit\Services\Validators;

use App\Services\Validators\ActorDataValidator;
use PHPUnit\Framework\TestCase;

class ActorDataValidatorTest extends TestCase
{
    private ActorDataValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new ActorDataValidator();
    }

    public function test_validates_successfully_with_all_required_fields(): void
    {
        $data = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'address' => '123 Main St',
        ];

        $this->validator->validate($data);

        $this->assertTrue(true);
    }

    public function test_validates_successfully_with_optional_fields(): void
    {
        $data = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'address' => '123 Main St',
            'height' => '180cm',
            'weight' => '75kg',
            'gender' => 'male',
            'age' => 30,
        ];

        $this->validator->validate($data);

        $this->assertTrue(true);
    }

    public function test_throws_exception_when_first_name_missing(): void
    {
        $data = [
            'lastName' => 'Doe',
            'address' => '123 Main St',
        ];

        $this->expectException(\Exception::class);

        $this->validator->validate($data);
    }

    public function test_throws_exception_when_last_name_missing(): void
    {
        $data = [
            'firstName' => 'John',
            'address' => '123 Main St',
        ];

        $this->expectException(\Exception::class);

        $this->validator->validate($data);
    }

    public function test_throws_exception_when_address_missing(): void
    {
        $data = [
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $this->expectException(\Exception::class);

        $this->validator->validate($data);
    }

    public function test_throws_exception_when_first_name_empty(): void
    {
        $data = [
            'firstName' => '',
            'lastName' => 'Doe',
            'address' => '123 Main St',
        ];

        $this->expectException(\Exception::class);

        $this->validator->validate($data);
    }

    public function test_returns_required_fields(): void
    {
        $expected = ['firstName', 'lastName', 'address'];

        $result = $this->validator->getRequiredFields();

        $this->assertEquals($expected, $result);
    }
}
