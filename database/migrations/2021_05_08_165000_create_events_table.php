<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('type')->comment('事件类型');
            $table->string('description')->comment('事件描述');
            $table->text('resolution')->comment('处理方法');
            $table->unsignedTinyInteger('part')->nullable()->comment('更换部件');
            $table->string('partname')->nullable()->comment('更换部件名称或型号');
            $table->datetime('startdate')->nullable()->comment('开始时间');
            $table->datetime('enddate')->nullable()->comment('结束时间');
            $table->string('maintainer')->nullable()->comment('维修人员');
            $table->boolean('isok')->default(true)->nullable()->comment('是否修好');

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
        Schema::dropIfExists('events');
    }
}
