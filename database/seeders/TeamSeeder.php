<?php

namespace Database\Seeders;

use App\Actions\Jetstream\CreateTeam;
use App\Models\Membership;
use App\Models\Team;
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
            $team = new Team();
            $team->name = $teamName;
            $team->user_id = $user->id;
            if($key == 'personal') {
                $team->personal_team = true;
            } else {
                $team->personal_team = false;
            }
            $team->save();

            $memberShip = new Membership();
            $memberShip->team_id = $team->id;
            $memberShip->user_id = $user->id;
            $memberShip->role = __('Owner');
            $memberShip->save();
        }
    }
}
