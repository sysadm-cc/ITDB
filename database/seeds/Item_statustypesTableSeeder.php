<?php

use Illuminate\Database\Seeder;

use App\Models\Item\Item_statustypes;

class Item_statustypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Item_statustypes::truncate();
		
        Item_statustypes::insert(array (
            0 => 
            array (
                'id' => 1,
                'statusdesc' => '使用',
                'color' => 'blue',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'statusdesc' => '保留',
                'color' => 'green',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'statusdesc' => '故障',
                'color' => 'red',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'statusdesc' => '报废',
                'color' => 'gray',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'statusdesc' => '维修',
                'color' => 'yellow',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'statusdesc' => '遗失',
                'color' => 'black',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
