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
		
        $table->string('stitle')->comment('软件名称');
        $table->integer('invoiceid')->nullable()->comment('发票编号');
        $table->string('slicenseinfo')->comment('License信息');
        $table->string('stype')->nullable()->comment('软件类型');
        $table->integer('manufacturerid')->nullable()->comment('制造商编号');
        $table->string('sversion')->nullable()->comment('版本');
        $table->string('sinfo')->nullable()->comment('信息');
        $table->datetime('purchdate')->nullable()->comment('购买日期');
        $table->integer('licqty')->nullable()->comment('License数量');
        $table->string('lictype')->nullable()->comment('License类型（Box/CPU/Core）');


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
