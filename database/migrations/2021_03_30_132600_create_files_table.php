<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('文件名称');
            $table->integer('type')->nullable()->comment('文件类型');
            $table->string('originalfilename')->nullable()->comment('原始文件名');
            $table->string('remotefilename')->nullable()->comment('远程文件名');
            $table->string('owner')->nullable()->comment('文件所属者');
            $table->string('uploader')->nullable()->comment('上传者');

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
        Schema::dropIfExists('files');
    }
}
