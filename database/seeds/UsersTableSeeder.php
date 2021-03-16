<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		$logintime = date("Y-m-d H:i:s", 86400);
		
        //
		User::truncate();
		
		// DB::table('configs')->insert(array (
		User::insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'ldapname' => 'admin',
                'email' => 'admin@sysadm.local',
                'displayname' => 'admin',
                'department' => 'sysadm',
                'password' => '$2y$10$LZyZUTTyHugBeHGiSCumi.KKb4doF5eQYoKqIBYR03J84LLcEVVZW', // 默认密码123
                'login_time' => $logintime,
                'login_ip' => '255.255.255.255',
                'login_counts' => 0,
                'remember_token' => '',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'user',
                'ldapname' => 'user',
                'email' => 'user@sysadm.local',
                'displayname' => 'user',
                'department' => 'sysadm',
                'password' => '$2y$10$ihmDQIgX4hK8CPfH3PtImeeVW8mmAeP42I4Jbx0GcLtXtLiKxLaRi',
                'login_time' => $logintime,
                'login_ip' => '255.255.255.255',
                'login_counts' => 0,
                'remember_token' => '',
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
