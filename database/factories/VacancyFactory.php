<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'employment_type' => 'Full-time',
            'job_location_type' => 'Remote',
            'location' => '',
            'salary_frequency' => 'per_year',
            'salary' => '30000000',
            'full_description' => fake()->text($maxNbChars = 300)
        ];
    }
}