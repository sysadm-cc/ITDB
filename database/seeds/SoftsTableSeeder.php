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
                'stitle' => 'RedHat Linux',
                'invoiceid' => null,
                'slicenseinfo' => null,
                'stype' => null,
                'manufacturerid' => null,
                'sversion' => null,
                'sinfo' => null,
                'purchdate' => null,
                'licqty' => 1,
                'lictype' => 'Box',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
