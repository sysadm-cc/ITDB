<?php

use Illuminate\Database\Seeder;

use App\Models\Location\Locations;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Locations::truncate();

        Locations::insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '开发区A区中心机房',
                'building' => '开发大厦A区B座',
                'floor' => '六楼东侧',
                'areas' => null,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
