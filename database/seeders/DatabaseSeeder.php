<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Project::factory()->count(10)->create([
            'name'    => fake()->text(30),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        Task::factory()->count(100)->create([
            'text'       => fake()->text(30),
            'user_id'    => User::inRandomOrder()->first()->id,
            'project_id' => Project::inRandomOrder()->first()->id,
        ]);
    }
}
