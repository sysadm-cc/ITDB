<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('racks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('机架名称');
            $table->string('model')->nullable()->comment('机架型号');
            $table->integer('usize')->nullable()->comment('U数');
            $table->integer('depth')->nullable()->comment('深度（mm）');
            $table->boolean('revnums')->default(false)->comment('U数顺序（默认从下向上为0，从上向下为1）');
            $table->integer('locationid')->nullable()->comment('机架所在位置');
            $table->integer('area')->nullable()->comment('机架所在区域/房间');
            $table->string('label')->nullable()->comment('标签');
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
        Schema::dropIfExists('racks');
    }
}
