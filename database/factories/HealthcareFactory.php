<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Healthcare;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Healthcare>
 */
class HealthcareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Healthcare::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'specialty' => $this->faker->word,
            // Add more attributes as needed
        ];
    }
}
