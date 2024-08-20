<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserTask;
use Illuminate\Support\Facades\Hash;


class UserTaskSeeder extends Seeder
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

        UserTask::create([
            'user_id' => 1,
            'task_id' => 1,
        ]);

        // And now let's generate a few dozen users for our app:
        for ($i = 2; $i < 20; $i++) {
            UserTask::create([
                'user_id' => rand(1, 5),
                'task_id' => $i,
            ]);
        }
    }
}
