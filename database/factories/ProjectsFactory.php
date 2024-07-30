<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projects>
 */
class ProjectsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_number' => $this->faker->randomNumber(1, 999),
            'home_style' => $this->faker->randomNumber(1, 999),
            'homespec_id' => $this->faker->randomNumber(1, 999),
            'project_address' => $this->faker->address(),
        ];
    }
}
