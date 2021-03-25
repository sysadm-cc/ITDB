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
                'itemtypeid' => 1,
                'function' => 'Software Firewall',
                'manufacturerid' => 1,
                'model' => 'Optiplex 790',
                'sn' => '123-456',
                'sn2' => NULL,
                'sn3' => NULL,
                'origin' => NULL,
                'warrantymonths' => 36,
                'purchasedate' => NULL,
                'purchprice' => NULL,
                'dnsname' => 'sysadm.local',
                'maintenanceinfo' => NULL,
                'comments' => NULL,
                'ispart' => false,
                'hd' => NULL,
                'cpu' => NULL,
                'ram' => NULL,
                'locationid' => 1,
                'userid' => 1,
                'ipv4' => '10.0.0.1',
                'ipv6' => NULL,
                'usize' => NULL,
                'rackmountable' => false,
                'macs' => NULL,
                'remadmip' => NULL,
                'panelport' => NULL,
                'ports' => NULL,
                'switchport' => NULL,
                'switchid' => NULL,
                'rackid' => NULL,
                'rackposition' => NULL,
                'label' => NULL,
                'status' => 1,
                'cpuno' => NULL,
                'corespercpu' => NULL,
                'rackposdepth' => NULL,
                'warrinfo' => NULL,
                'locareaid' => 1,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
