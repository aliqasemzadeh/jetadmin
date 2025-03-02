<?php

namespace App\Console\Commands\System\Administrator;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreatePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:administrator:create-permissions-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = Role::findByName('user');
        $permissions_user = __('permissions.user');

        foreach ($permissions_user as $permission => $translate) {
            Permission::create(
                ['name' => $permission]
            );
        }

        foreach ($permissions_user as $permission => $translate) {
            $user->givePermissionTo($permission);
        }

        $administrator = Role::findByName('administrator');
        $permissions_administrator = __('permissions.administrator');

        foreach ($permissions_administrator as $permission => $translate) {
            Permission::create(
                ['name' => $permission]
            );
        }

        foreach ($permissions_administrator as $permission => $translate) {
            $administrator->givePermissionTo($permission);
        }


    }
}
