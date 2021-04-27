<?php

use Illuminate\Database\Seeder;

use App\Models\Employee\Employees;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Employees::truncate();
		
        Employees::insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '网管小贾',
                'userid' => '20211202666',
                'email' => 'wangguanxiaojia@sysadm.local',
                'department' => 'IT',
                'gender' => true,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '孔大力',
                'userid' => '20211202888',
                'email' => 'kongdali@sysadm.local',
                'department' => '挨踢部',
                'gender' => true,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '白小萌',
                'userid' => '20211202999',
                'email' => 'baixiaomeng@sysadm.local',
                'department' => '财务部',
                'gender' => false,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
