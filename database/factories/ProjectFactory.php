<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            // Generate a unique ID since auto-increment is off
            'project_id'    => $this->faker->unique()->numberBetween(1, 9999),
            'name'          => $this->faker->words(3, true) . ' Research',
            'balance'       => $this->faker->randomFloat(2, 0, 100000),
            'state'         => $this->faker->randomElement(['active', 'pending', 'completed']),
            'supervisor_id' => $this->faker->numberBetween(1, 50), 
        ];
    }
}