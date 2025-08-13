<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create first test user
        $user1 = User::factory()->create([
            'name' => 'Test User 1',
            'email' => 'test1@example.com',
            'password' => Hash::make('123456'), // login password
        ]);

        // Create 10 fake tasks for first user
        Task::factory()->count(10)->create([
            'user_id' => $user1->id
        ]);

        // Create second test user
        $user2 = User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => Hash::make('123456'), // login password
        ]);

        // Create 10 fake tasks for second user
        Task::factory()->count(10)->create([
            'user_id' => $user2->id
        ]);
    }
}
