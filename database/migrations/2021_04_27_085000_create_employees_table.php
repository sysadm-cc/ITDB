<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique()->comment('姓名');
            $table->string('userid')->unique()->nullable()->comment('用户ID');
            $table->string('email')->nullable()->comment('电子邮件');
            $table->string('department')->nullable()->comment('部门');
            $table->boolean('gender')->default(true)->nullable()->comment('性别');
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
        Schema::dropIfExists('employees');
    }
}
