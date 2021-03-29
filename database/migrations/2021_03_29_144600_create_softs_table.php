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
