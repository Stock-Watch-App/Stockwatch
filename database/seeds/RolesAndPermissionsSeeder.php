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
        Role::firstOrCreate(['name' => 'super admin']);
        Role::firstOrCreate(['name' => 'admin']);

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
            'week',
        ];
        foreach ($models as $model) {
            $view = Permission::firstOrCreate(['name' => "view {$model}"]);
            $create = Permission::firstOrCreate(['name' => "create {$model}"]);
            $update = Permission::firstOrCreate(['name' => "update {$model}"]);
            $delete = Permission::firstOrCreate(['name' => "delete {$model}"]);
            $restore = Permission::firstOrCreate(['name' => "restore {$model}"]);
            $force = Permission::firstOrCreate(['name' => "force delete {$model}"]);

            Role::firstOrCreate(['name' => "manage {$model}"])
                ->givePermissionTo([$view, $create, $update, $delete, $restore, $force]);
        }

        Permission::firstOrCreate(['name' => 'ban user']);

        Permission::firstOrCreate(['name' => 'open market']);
        Permission::firstOrCreate(['name' => 'close market']);

        Permission::firstOrCreate(['name' => 'edit permissions']);
        Permission::firstOrCreate(['name' => 'impersonate']);

        Role::firstOrCreate(['name' => 'lfc'])
            ->givePermissionTo(['view houseguest', 'view season', 'view rating', 'create rating', 'update rating', 'delete rating']);

//        if (env('APP_ENV', 'production') === 'local') {
//            \App\Models\User::find(1)->assignRole('super admin');
//        }
    }
}
