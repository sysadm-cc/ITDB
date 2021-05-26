<?php

use Illuminate\Database\Seeder;

use App\Models\File\Files;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Files::truncate();

        Files::insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '文件一',
                'type' => 1,
                'originalfilename' => 'xxx.pdf',
                'remotefilename' => 'files/xxx.pdf',
                'uploader' => 'admin',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
