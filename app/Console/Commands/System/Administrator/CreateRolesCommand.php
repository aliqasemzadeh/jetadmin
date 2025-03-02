<?php

namespace App\Console\Commands\System\Administrator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRolesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:administrator:create-roles-command';

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
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Permission::truncate();
        DB::table('role_has_permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach (__('roles') as $role => $roleTitle) {
            Role::create(['name' => $role]);
        }
    }
}
