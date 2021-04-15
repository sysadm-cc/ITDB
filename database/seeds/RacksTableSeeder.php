<?php

use Illuminate\Database\Seeder;

use App\Models\Rack\Racks;

class RacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Racks::truncate();

        Racks::insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '机柜一号',
                'model' => 'XX品牌XX型号50U',
                'usize' => 50,
                'depth' => null,
                // 'revnums' => 0,
                'locationid' => 1,
                'area' => null,
                'label' => null,
                'comments' => null,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
