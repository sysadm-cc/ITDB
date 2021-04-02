<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('type')->nullable()->comment('代理商类型');
            $table->string('title')->comment('代理商名称');
            $table->string('contactinfo')->nullable()->comment('备注');
            $table->json('contacts')->nullable()->comment('联系方式');
            $table->json('urls')->nullable()->comment('URLs');
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
        Schema::dropIfExists('agents');
    }
}
