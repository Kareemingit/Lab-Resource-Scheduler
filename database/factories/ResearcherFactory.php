<?php

namespace Database\Factories;

use App\Models\Researcher;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Researcher>
 */
class ResearcherFactory extends Factory
{
    protected $model = Researcher::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'project_id' => Project::factory(),
        ];
    }
}
