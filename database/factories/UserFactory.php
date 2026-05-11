<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'name'     => $this->faker->name(),
            'password' => Hash::make('password'),
            'role'     => $this->faker->randomElement(['admin', 'researcher', 'lab_manager']),
        ];
    }
}