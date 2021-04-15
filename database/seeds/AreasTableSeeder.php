<?php

use Illuminate\Database\Seeder;

use App\Models\Location\Areas;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Areas::truncate();

        Areas::insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '开发区A区中心机房',
                'building' => '开发大厦A区B座',
                'floor' => '六楼东侧',
                'area' => '666号中心机房',
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
