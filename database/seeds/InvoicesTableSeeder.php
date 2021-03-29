<?php

use Illuminate\Database\Seeder;

use App\Models\Invoice\Invoices;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$nowtime = date("Y-m-d H:i:s",time());
		
		Invoices::truncate();

        Invoices::insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '发票一',
                'vendorid' => 1,
                'ordernumber' => null,
                'buyer' => null,
                'invoicedate' => null,
                'description' => null,
                'created_at' => $nowtime,
                'updated_at' => $nowtime,
                'deleted_at' => NULL,
            ),
        ));
	}
}
