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
        
		$this->call(EventsTableSeeder::class);
		$this->call(EmployeesTableSeeder::class);
		$this->call(LocationsTableSeeder::class);
		$this->call(RacksTableSeeder::class);
		$this->call(FilesTableSeeder::class);
		$this->call(ContracttypesTableSeeder::class);
		$this->call(ContractsTableSeeder::class);
		$this->call(InvoicesTableSeeder::class);
		$this->call(AgentsTableSeeder::class);
		$this->call(SoftsTableSeeder::class);
		$this->call(Item_itemsTableSeeder::class);
		$this->call(Item_itemtypesTableSeeder::class);
		$this->call(Item_statustypesTableSeeder::class);

    }
}
