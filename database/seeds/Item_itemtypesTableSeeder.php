<?php

use Illuminate\Database\Seeder;

use App\Models\Item\Item_itemtypes;

class Item_itemtypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Item_itemtypes::truncate();
		
        Item_itemtypes::insert(array (
            0 => 
            array (
                'id' => 1,
                'typedesc' => '台式机',
                'hassoftware' => true,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'typedesc' => '笔记本',
                'hassoftware' => true,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'typedesc' => '显示器',
                'hassoftware' => false,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'typedesc' => '交换机',
                'hassoftware' => false,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'typedesc' => '路由器',
                'hassoftware' => false,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'statusdesc' => '打印机',
                'hassoftware' => false,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'statusdesc' => '传真机',
                'hassoftware' => false,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'statusdesc' => '无线AP',
                'hassoftware' => false,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
