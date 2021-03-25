<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('itemtypeid')->nullable()->unsigned()->comment('项目类型编号');
            $table->string('function')->nullable()->comment('功能');
            $table->integer('manufacturerid')->nullable()->unsigned()->comment('制造商编号');
            $table->string('model')->comment('型号');
            $table->string('sn')->nullable()->comment('序列号一');
            $table->string('sn2')->nullable()->comment('序列号二');
            $table->string('sn3')->nullable()->comment('序列号三');
            $table->string('origin')->nullable()->comment('origin');
            $table->integer('warrantymonths')->nullable()->unsigned()->comment('保修月份');
            $table->integer('purchasedate')->nullable()->unsigned()->comment('购买日期');
            $table->string('purchprice')->nullable()->comment('购买价格');
            $table->string('dnsname')->nullable()->comment('域名');
            $table->string('maintenanceinfo')->nullable()->comment('维护信息');
            $table->string('comments')->nullable()->comment('备注');
            $table->boolean('ispart')->default(false)->comment('是否是部件');
            $table->string('hd')->nullable()->comment('硬盘');
            $table->string('cpu')->nullable()->comment('CPU');
            $table->string('ram')->nullable()->comment('内存');
            $table->integer('locationid')->nullable()->unsigned()->comment('位置场所编号');
            $table->integer('userid')->nullable()->unsigned()->comment('用户ID');
            $table->string('ipv4')->nullable()->comment('ipv4');
            $table->string('ipv6')->nullable()->comment('ipv6');
            $table->integer('usize')->nullable()->unsigned()->comment('高度（单位U）');
            $table->boolean('rackmountable')->default(false)->comment('是否机架式');
            $table->string('macs')->nullable()->comment('MAC地址');
            $table->string('remadmip')->nullable()->comment('远程管理IP');
            $table->string('panelport')->nullable()->comment('面板端口');
            $table->integer('ports')->nullable()->unsigned()->comment('网络端口数量');
            $table->string('switchport')->nullable()->comment('接入交换机端口号');
            $table->integer('switchid')->nullable()->unsigned()->comment('交换机编号');
            $table->string('rackid')->nullable()->comment('机架编号');
            $table->integer('rackposition')->nullable()->unsigned()->comment('机架位置场所');
            $table->string('label')->nullable()->comment('标签');
            $table->integer('status')->nullable()->unsigned()->comment('状态');
            $table->integer('cpuno')->nullable()->unsigned()->comment('CPU数量');
            $table->integer('corespercpu')->nullable()->unsigned()->comment('每CPU内核数量');
            $table->integer('rackposdepth')->nullable()->unsigned()->comment('机架位置深度');
            $table->string('warrinfo')->nullable()->comment('保修信息');
            $table->integer('locareaid')->nullable()->unsigned()->comment('位置场所编号');
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
        Schema::dropIfExists('item_items');
    }
}
