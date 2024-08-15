<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;


class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::truncate();

        $faker = \Faker\Factory::create();

        // Let's make sure everyone has the same password and 
        // let's hash it before the loop, or else our seeder 
        // will be too slow.

        Task::create([
            'title' => 'Add title',
            'description' => 'description',
            'due_date' => now(),
            'status' => true,
        ]);

        // And now let's generate a few dozen users for our app:
        for ($i = 0; $i < 19; $i++) {
            Task::create([
                'title' => $faker->name,
                'description' => $faker->sentence,
                'due_date' => now()->addDays(rand(0, 30)),
                'status' => rand(true, false),
            ]);
        }
    }
}
