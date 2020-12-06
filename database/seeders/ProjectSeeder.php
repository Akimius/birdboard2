<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $usersId = User::all()->take(5)->pluck('id');

        Project::factory()->count(5)->create(['owner_id' => 1]);

        $i = 0;
        while ($i < 5) {
            Project::factory()->create(['owner_id' => $usersId->random()]);
            $i++;
        }
    }
}
