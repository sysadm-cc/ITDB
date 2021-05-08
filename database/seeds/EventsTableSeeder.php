<?php

use Illuminate\Database\Seeder;

use App\Models\Event\Events;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Events::truncate();
		
        Events::insert(array (
            0 => 
            array (
                'id' => 1,
                'type' => '硬件故障',
                'description' => '主板故障',
                'resolution' => '更换主板',
                'maintainer' => '网管小贾',
                'isok' => true,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'type' => '软件故障',
                'description' => '.Net组件错误',
                'resolution' => '重新安装.Net组件',
                'maintainer' => '孔大力',
                'isok' => true,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
