<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $faker = Faker::create();

        $user = User::create([
            'name' => 'Rama',
            'email' => 'rama@gmail.com',
            'password' => bcrypt('R@ma12345'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            Task::create([
                'user_id'     => $user->id,
                'title'       => $faker->sentence(3),
                'description' => $faker->paragraph(),
                'due_date'    => $faker->dateTimeBetween('now', '+10 days')->format('Y-m-d'),
                'status'      => $faker->randomElement(['pending', 'done']),
            ]);
        }
    }
}
