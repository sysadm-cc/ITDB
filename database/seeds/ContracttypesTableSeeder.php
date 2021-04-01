<?php

use Illuminate\Database\Seeder;

use App\Models\Contract\Contracttypes;

class ContracttypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Contracttypes::truncate();

        Contracttypes::insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '合同类型名称一',
                    
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
