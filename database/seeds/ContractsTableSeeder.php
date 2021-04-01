<?php

use Illuminate\Database\Seeder;

use App\Models\Contract\Contracts;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Contracts::truncate();

        Contracts::insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '合同名称一',
                'type' => 1,
                'number' => null,
                'description' => null,
                'comments' => null,
                'totalcost' => null,
                'startdate' => null,
                'currentenddate' => null,
                'renewals' => null,
                    
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
