<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('位置名称');
            $table->string('building')->nullable()->comment('建筑名称');
            $table->string('floor')->nullable()->comment('楼层');
            $table->string('area')->nullable()->comment('区域/房间');
            $table->float('x1')->nullable()->comment('坐标x1');
            $table->float('y1')->nullable()->comment('坐标y1');
            $table->float('x2')->nullable()->comment('坐标x2');
            $table->float('y2')->nullable()->comment('坐标y2');

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
        Schema::dropIfExists('locations');
    }
}
