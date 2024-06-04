<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setPermissionsTeamId(1);
        $admin = Role::create(['name' => 'admin', 'team_id' => 1]);
        $support = Role::create(['name' => 'support', 'team_id' => 1]);

        foreach (__('permissions') as $permission => $translate) {
            Permission::create(
                ['guard_name' => 'web', 'name' => $permission]
            );
            $admin->givePermissionTo($permission);
        }


        $user = User::findOrFail(1);
        $user->assignRole($admin);
        $user->assignRole($support);
    }
}
