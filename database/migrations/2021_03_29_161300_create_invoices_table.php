<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('发票名称');
            $table->integer('agentid')->comment('代理商');
            $table->string('ordernumber')->nullable()->comment('订单编号');
            $table->string('buyer')->nullable()->comment('购买者');
            $table->datetime('invoicedate')->nullable()->comment('发票日期');
            $table->text('description')->nullable()->comment('详细内容');

            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
