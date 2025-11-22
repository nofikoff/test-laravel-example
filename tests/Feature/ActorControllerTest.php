<?php

namespace Tests\Feature;

use App\Exceptions\ActorValidationException;
use App\Models\Actor;
use App\Services\ActorExtractionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_displays_actor_creation_form(): void
    {
        $response = $this->get(route('actors.create'));

        $response->assertStatus(200);
        $response->assertViewIs('actors.create');
        $response->assertSee('Submit Actor Information');
    }

    public function test_stores_actor_successfully(): void
    {
        $extractionService = $this->mock(ActorExtractionService::class);

        $rawData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'address' => '123 Main St',
            'height' => '180cm',
            'weight' => '75kg',
            'gender' => 'male',
            'age' => 30,
        ];

        $extractionService->shouldReceive('extractRawActorData')
            ->once()
            ->andReturn($rawData);

        $response = $this->post(route('actors.store'), [
            'email' => 'john@example.com',
            'description' => 'John Doe is 30 years old and lives at 123 Main St',
        ]);

        $response->assertRedirect(route('actors.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('actors', [
            'email' => 'john@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => '123 Main St',
        ]);
    }

    public function test_validates_required_fields(): void
    {
        $response = $this->post(route('actors.store'), []);

        $response->assertSessionHasErrors(['email', 'description']);
    }

    public function test_validates_unique_description(): void
    {
        Actor::factory()->create(['description' => 'Unique description']);

        $response = $this->post(route('actors.store'), [
            'email' => 'unique@example.com',
            'description' => 'Unique description',
        ]);

        $response->assertSessionHasErrors(['description']);
    }

    public function test_validates_unique_email(): void
    {
        Actor::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post(route('actors.store'), [
            'email' => 'existing@example.com',
            'description' => 'Some unique description',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_handles_extraction_service_exception(): void
    {
        $extractionService = $this->mock(ActorExtractionService::class);
        $extractionService->shouldReceive('extractRawActorData')
            ->once()
            ->andThrow(ActorValidationException::missingRequiredFields(['firstName', 'lastName']));

        $response = $this->post(route('actors.store'), [
            'email' => 'test@example.com',
            'description' => 'Incomplete data',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['description']);
    }

    public function test_displays_actors_index(): void
    {
        Actor::factory()->count(3)->create();

        $response = $this->get(route('actors.index'));

        $response->assertStatus(200);
        $response->assertViewIs('actors.index');
        $response->assertViewHas('actors');
    }

    public function test_api_returns_actors_collection(): void
    {
        Actor::factory()->count(3)->create();

        $response = $this->getJson(route('api.v1.actors.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'age',
                    'gender',
                    'height',
                    'weight',
                    'address',
                    'description',
                    'created_at',
                ],
            ],
        ]);
    }

    public function test_api_returns_prompt(): void
    {
        $response = $this->getJson(route('api.v1.actors.prompt'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
        $response->assertJson([
            'message' => config('ai.actor_extraction_prompt'),
        ]);
    }

    public function test_displays_prompt_page(): void
    {
        $response = $this->get(route('actors.prompt'));

        $response->assertStatus(200);
        $response->assertViewIs('actors.prompt');
        $response->assertSee('AI Prompt Configuration');
        $response->assertSee(config('ai.actor_extraction_prompt'));
        $response->assertSee(route('api.v1.actors.prompt'));
    }
}
