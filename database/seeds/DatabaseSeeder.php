<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FormulaSeeder::class);
        if (env('APP_ENV', 'production') === 'local') {
            $this->call(BBCan8TestingSeeder::class);
        } else {
            $this->call(BBCan8Seeder::class);
        }
        $this->call(RolesAndPermissionsSeeder::class);
    }
}
