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
		$this->call(UsersTableSeeder::class);
		$this->call(ConfigsTableSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        
		$this->call(Item_itemtypesTableSeeder::class);
		$this->call(Item_statustypesTableSeeder::class);

    }
}
