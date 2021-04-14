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
                'title' => 'XXXX技术支持合同',
                'type' => 1,
                'number' => null,
                'description' => null,
                'comments' => null,
                'totalcost' => null,
                'currency' => null,
                'startdate' => null,
                'currentenddate' => null,
                'renewals' => json_encode(array(), true),
                    
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
