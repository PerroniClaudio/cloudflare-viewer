<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\R2Connection>
 */
class R2ConnectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hex = fake()->hexColor();

        return [
            'name' => fake()->words(2, true),
            'color' => '#'.ltrim($hex, '#'),
            'access_key_id' => fake()->regexify('[A-Z0-9]{20}'),
            'secret_access_key' => fake()->regexify('[A-Za-z0-9/+=]{40}'),
            'endpoint' => fake()->url(),
            'bucket' => fake()->uuid(),
        ];
    }
}
