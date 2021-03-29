<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemItemtypesTable extends Migration
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
            $table->integer('type')->comment('代理商类型');
            $table->string('title')->comment('代理商名称');
            $table->string('contactinfo')->comment('联系信息');
            $table->string('contacts')->comment('联系方式');
            $table->string('urls')->comment('URL');
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
