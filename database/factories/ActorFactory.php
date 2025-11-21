<?php

namespace Database\Factories;

use App\Models\Actor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActorFactory extends Factory
{
    /** @var class-string<Actor> */
    protected $model = Actor::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'description' => fake()->paragraph(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'address' => fake()->address(),
            'height' => fake()->randomElement(['170cm', '175cm', '180cm', '185cm', null]),
            'weight' => fake()->randomElement(['65kg', '70kg', '75kg', '80kg', null]),
            'gender' => fake()->randomElement(['male', 'female', null]),
            'age' => fake()->numberBetween(18, 65),
        ];
    }
}
