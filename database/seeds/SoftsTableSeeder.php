<?php

use Illuminate\Database\Seeder;

use App\Models\Soft\Softs;

class SoftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Softs::truncate();

        Softs::insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'RedHat Linux',
                'agentid' => null,
                'invoiceid' => null,
                'type' => null,
                'version' => null,
                'purchasedate' => null,
                'quantity' => 1,
                'licenseinfo' => null,
                'comments' => null,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
