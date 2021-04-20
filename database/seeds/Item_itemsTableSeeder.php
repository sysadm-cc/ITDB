<?php

use Illuminate\Database\Seeder;

use App\Models\Item\Item_items;

class Item_itemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Item_items::truncate();
		
        Item_items::insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'DELL台式机',
                'itemtypeid' => 1,
                'ispart' => false,
                'rackmountable' => false,
                'agentid' => 1,
                'model' => 'Optiplex 790',
                'usize' => NULL,
                'assettag' => NULL,
                'sn1' => NULL,
                'sn2' => NULL,
                'servicetag' => '123-456',
                'comments' => NULL,

                'status' => 1,
                'userid' => 1,
                'locationid' => 1,
                'areaid' => 1,
                'rackid' => NULL,
                'rackposition' => NULL,
                'rackdepth' => NULL,
                'function' => 'Software Firewall',
                'maintenanceinstructions' => NULL,

                'shop' => NULL,
                'purchprice' => NULL,
                'purchasedate' => NULL,
                'warrantymonths' => 36,
                'warrantyinfo' => NULL,

                'hd' => NULL,
                'ram' => NULL,
                'cpu' => NULL,
                'cpuno' => NULL,
                'corespercpu' => NULL,

                'dns' => 'sysadm.local',
                'maclan' => NULL,
                'macwl' => NULL,
                'ipv4lan' => '10.0.0.1',
                'ipv4wl' => '10.0.0.2',
                'ipv6lan' => NULL,
                'ipv6wl' => NULL,
                'remadmip' => NULL,
                'panelport' => NULL,
                'switchid' => NULL,
                'switchport' => NULL,
                'ports' => NULL,

                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
