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
                'title' => '位置场所一',
                'building' => '开发大厦',
                'floor' => '三楼',
                'area' => '中心机房',
                'x1' => null,
                'y1' => null,
                'x2' => null,
                'y2' => null,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
