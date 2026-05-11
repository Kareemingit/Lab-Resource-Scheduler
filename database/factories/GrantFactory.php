<?php

namespace Database\Factories;

use App\Models\Grant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grant>
 */
class GrantFactory extends Factory
{
    protected $model = Grant::class;

    public function definition(): array
    {
        return [
            'grant_id'     => $this->faker->unique()->numberBetween(1000, 9999), 
            'name'         => $this->faker->sentence(3),
            'fund'         => $this->faker->randomFloat(2, 1000, 50000),
            'end_date'     => $this->faker->dateTimeBetween('now', '+2 years'),
            'financial_id' => $this->faker->bothify('FIN-####'),
            'project_id'   => Project::factory()
        ];
    }
}
