<?php

namespace Database\Seeders;

use App\Actions\Jetstream\CreateTeam;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::findOrFail(1);
        foreach (__('teams') as $key => $teamName) {
            new CreateTeam($user, [
                'name' => $teamName
            ]);
        }
    }
}
