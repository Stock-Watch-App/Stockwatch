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
        $models = [
            'bank',
            'houseguest',
            'price',
            'rating',
            'season',
            'stock',
            'transaction',
            'user',
        ];
        foreach ($models as $model) {
            Permission::create(['name' => "view {$model}"]);
            Permission::create(['name' => "create {$model}"]);
            Permission::create(['name' => "update {$model}"]);
            Permission::create(['name' => "delete {$model}"]);
            Permission::create(['name' => "restore {$model}"]);
            Permission::create(['name' => "force delete {$model}"]);

            Role::create(["manage {$model}"])
                ->givePermissionTo(["view {$model}","create {$model}","update {$model}","delete {$model}","restore {$model}","force delete {$model}"]);
        }


        Permission::create(['name' => 'ban user']);

        Permission::create(['name' => 'open market']);
        Permission::create(['name' => 'close market']);

        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'impersonate']);


        // create roles and assign created permissions
        Role::create(['name' => 'super admin']);
        Role::create(['name' => 'admin']);
    }
}
