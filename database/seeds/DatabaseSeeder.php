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
         $this->call(BBCan8Seeder::class);
         $this->call(RolesAndPermissionsSeeder::class);
    }
}
