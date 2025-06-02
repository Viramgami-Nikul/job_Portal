<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Job;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        \App\Models\User::factory(10)->create();
         

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //jab seeder run karenge tab category and jobtype table me 5 dumi recored insert honge
        //command db:seed

        // \App\Models\Category::factory(5)->create();
        // \App\Models\JobType::factory(5)->create();

        // \App\Models\Job::factory(20)->create();

    }
}
