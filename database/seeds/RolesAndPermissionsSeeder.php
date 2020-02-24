<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create houseguest']);
        Permission::create(['name' => 'edit houseguest']);
        Permission::create(['name' => 'delete houseguest']);

        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'ban user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'add rank']);
        Permission::create(['name' => 'edit rank']);
        Permission::create(['name' => 'delete rank']);
        Permission::create(['name' => 'show rank']);

        Permission::create(['name' => 'open market']);
        Permission::create(['name' => 'close market']);
        Permission::create(['name' => 'edit stock']);

        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'impersonate']);


        // create roles and assign created permissions
        Role::create(['name' => 'super admin']);
        Role::create(['name' => 'admin'])
            ->givePermissionTo(['edit permissions','impersonate','create houseguest','edit houseguest','delete houseguest']);
        Role::create(['name' => 'lfc'])
            ->givePermissionTo(['add rank','edit rank','delete rank','show rank']);
        Role::create(['name' => 'user moderator'])
            ->givePermissionTo(['create user','edit user','ban user','delete user']);
        Role::create(['name' => 'market moderator'])
            ->givePermissionTo(['open market','close market','edit stock']);

    }
}
