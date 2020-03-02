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

        // create roles and assign created permissions
        Role::create(['name' => 'super admin']);
        Role::create(['name' => 'admin']);

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
            $view = Permission::create(['name' => "view {$model}"]);
            $create = Permission::create(['name' => "create {$model}"]);
            $update = Permission::create(['name' => "update {$model}"]);
            $delete = Permission::create(['name' => "delete {$model}"]);
            $restore = Permission::create(['name' => "restore {$model}"]);
            $force = Permission::create(['name' => "force delete {$model}"]);

            Role::create(['name' => "manage {$model}"])
                ->givePermissionTo([$view, $create, $update, $delete, $restore, $force]);
        }

        Permission::create(['name' => 'ban user']);

        Permission::create(['name' => 'open market']);
        Permission::create(['name' => 'close market']);

        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'impersonate']);
    }
}
