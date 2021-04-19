<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('softs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('软件名称');
            $table->integer('agentid')->nullable()->comment('制造商编号');
            $table->integer('invoiceid')->nullable()->comment('发票编号');
            $table->string('type')->nullable()->comment('软件License类型（Box/CPU/Core）');
            $table->string('version')->nullable()->comment('版本');
            $table->datetime('purchasedate')->nullable()->comment('购买日期');
            $table->integer('quantity')->nullable()->comment('License数量');
            $table->string('licenseinfo')->nullable()->comment('License信息');
            $table->string('comments')->nullable()->comment('备注');

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
        Schema::dropIfExists('softs');
    }
}
