<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('合同名称');
            $table->integer('type')->nullable()->comment('合同类型');
            $table->string('number')->nullable()->comment('合同编号');
            $table->text('description')->nullable()->comment('合同详细描述');
            $table->string('comments')->nullable()->comment('备注');
            $table->string('totalcost')->nullable()->comment('总价值');
            $table->datetime('startdate')->nullable()->comment('开始日期');
            $table->datetime('currentenddate')->nullable()->comment('当前结束日期');
            $table->json('renewals')->nullable()->comment('合同续约');

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
        Schema::dropIfExists('contracts');
    }
}
