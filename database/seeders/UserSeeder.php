<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->email = 'info@jetadmin.local';
        $user->password = Hash::make('P@ssw0rd321');
        $user->email_verified_at = Carbon::now();
        $user->save();
    }
}
