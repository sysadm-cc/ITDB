<?php

use Illuminate\Database\Seeder;

use App\Models\Item\Agents;

class AgentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Agents::truncate();
		
        Agents::insert(array (
            0 => 
            array (
                'id' => 1,
                'type' => null,
                'title' => 'Lenovo',
                'contactinfo' => '联想',
                'contacts' => 'xxx-xxxxxxxx',
                'urls' => 'https://www.lenovo.com.cn',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'type' => null,
                'title' => 'Dell',
                'contactinfo' => '戴尔',
                'contacts' => 'yyy-yyyyyyyy',
                'urls' => 'https://www.dell.com',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
