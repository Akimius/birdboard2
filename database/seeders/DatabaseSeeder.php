<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->create(
            [
                'id'       => 1,
                'email'    => 'akim.savchenko@gmail.com',
                'name'     => 'Akimius',
                'password' => '12345678',
            ]
        );

        User::factory()->count(4)->create();

        (new ProjectSeeder())->run();
    }
}
