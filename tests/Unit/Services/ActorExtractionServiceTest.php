<?php

namespace Tests\Unit\Services;

use App\Contracts\AIServiceInterface;
use App\Services\ActorExtractionService;
use App\Services\Transformers\ActorDataTransformer;
use Mockery;
use Tests\TestCase;

class ActorExtractionServiceTest extends TestCase
{
    private ActorExtractionService $service;
    private AIServiceInterface $mockAiService;
    private ActorDataTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockAiService = Mockery::mock(AIServiceInterface::class);
        $this->transformer = new ActorDataTransformer();

        $this->service = new ActorExtractionService(
            $this->mockAiService,
            $this->transformer
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_extracts_actor_data_successfully(): void
    {
        $description = 'John Doe is 30 years old and lives at 123 Main St';

        $aiResponse = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'address' => '123 Main St',
            'age' => 30,
        ];

        $this->mockAiService
            ->shouldReceive('extractStructuredData')
            ->once()
            ->andReturn($aiResponse);

        $result = $this->service->extractActorData($description);

        $this->assertEquals('John', $result['first_name']);
        $this->assertEquals('Doe', $result['last_name']);
        $this->assertEquals('123 Main St', $result['address']);
        $this->assertEquals(30, $result['age']);
    }

    public function test_extracts_with_all_fields(): void
    {
        $description = 'Jane Smith, 25, female, 165cm, 55kg, lives at 456 Oak Ave';

        $aiResponse = [
            'firstName' => 'Jane',
            'lastName' => 'Smith',
            'address' => '456 Oak Ave',
            'height' => '165cm',
            'weight' => '55kg',
            'gender' => 'female',
            'age' => 25,
        ];

        $this->mockAiService
            ->shouldReceive('extractStructuredData')
            ->once()
            ->andReturn($aiResponse);

        $result = $this->service->extractActorData($description);

        $this->assertEquals('Jane', $result['first_name']);
        $this->assertEquals('Smith', $result['last_name']);
        $this->assertEquals('456 Oak Ave', $result['address']);
        $this->assertEquals('165cm', $result['height']);
        $this->assertEquals('55kg', $result['weight']);
        $this->assertEquals('female', $result['gender']);
        $this->assertEquals(25, $result['age']);
    }

    public function test_handles_optional_fields_as_null(): void
    {
        $description = 'Bob Brown lives at 789 Pine Rd';

        $aiResponse = [
            'firstName' => 'Bob',
            'lastName' => 'Brown',
            'address' => '789 Pine Rd',
        ];

        $this->mockAiService
            ->shouldReceive('extractStructuredData')
            ->once()
            ->andReturn($aiResponse);

        $result = $this->service->extractActorData($description);

        $this->assertEquals('Bob', $result['first_name']);
        $this->assertEquals('Brown', $result['last_name']);
        $this->assertEquals('789 Pine Rd', $result['address']);
        $this->assertNull($result['height']);
        $this->assertNull($result['weight']);
        $this->assertNull($result['gender']);
        $this->assertNull($result['age']);
    }

    public function test_uses_config_prompt(): void
    {
        $description = 'Test description';
        $expectedPrompt = config('ai.actor_extraction_prompt');

        $aiResponse = [
            'firstName' => 'Test',
            'lastName' => 'User',
            'address' => 'Test Address',
        ];

        $this->mockAiService
            ->shouldReceive('extractStructuredData')
            ->once()
            ->with($expectedPrompt, $description)
            ->andReturn($aiResponse);

        $result = $this->service->extractActorData($description);

        $this->assertNotEmpty($result);
    }

    public function test_extracts_raw_actor_data(): void
    {
        $description = 'Test description';
        $expectedPrompt = config('ai.actor_extraction_prompt');

        $aiResponse = [
            'firstName' => 'Test',
            'lastName' => 'User',
            'address' => 'Test Address',
        ];

        $this->mockAiService
            ->shouldReceive('extractStructuredData')
            ->once()
            ->with($expectedPrompt, $description)
            ->andReturn($aiResponse);

        $result = $this->service->extractRawActorData($description);

        $this->assertEquals('Test', $result['firstName']);
        $this->assertEquals('User', $result['lastName']);
        $this->assertEquals('Test Address', $result['address']);
    }
}
