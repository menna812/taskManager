<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Creates a user automatically if not provided
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'is_completed' => $this->faker->boolean(),
        ];
    }
}
