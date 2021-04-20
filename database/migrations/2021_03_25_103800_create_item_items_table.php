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
            $table->integer('itemtypeid')->nullable()->unsigned()->comment('物品类型编号');
            $table->boolean('ispart')->default(false)->comment('是否是部件');
            $table->boolean('rackmountable')->default(false)->comment('是否机架式');
            $table->integer('agentid')->nullable()->unsigned()->comment('代理商编号');
            $table->string('model')->comment('型号');
            $table->integer('usize')->nullable()->unsigned()->comment('尺寸（单位U）');
            $table->string('assettag')->nullable()->comment('资产标签');
            $table->string('sn1')->nullable()->comment('序列号1');
            $table->string('sn2')->nullable()->comment('序列号2');
            $table->string('servicetag')->nullable()->comment('服务编号');
            $table->string('comments')->nullable()->comment('备注');

            $table->integer('status')->nullable()->unsigned()->comment('状态');
            $table->integer('userid')->nullable()->unsigned()->comment('用户ID');
            $table->integer('locationid')->nullable()->unsigned()->comment('位置/楼层');
            $table->integer('areaid')->nullable()->unsigned()->comment('位置场所编号');
            $table->string('rackid')->nullable()->comment('机柜编号');
            $table->integer('rackposition')->nullable()->unsigned()->comment('所在机柜高度');
            $table->integer('rackdepth')->nullable()->unsigned()->comment('所在机柜深度');
            $table->string('function')->nullable()->comment('功能用途');
            $table->string('maintenanceinstructions')->nullable()->comment('具体使用说明');
            
            $table->dateTime('purchasedate')->nullable()->comment('购买日期');
            $table->integer('warrantymonths')->nullable()->unsigned()->comment('保修时长（月）');
            $table->string('warrantyinfo')->nullable()->comment('保修信息');

            $table->string('hd')->nullable()->comment('硬盘');
            $table->string('ram')->nullable()->comment('内存');
            $table->string('cpu')->nullable()->comment('CPU');
            $table->integer('cpuno')->nullable()->unsigned()->comment('CPU数量');
            $table->integer('corespercpu')->nullable()->unsigned()->comment('每CPU内核数量');

            $table->string('dnsname')->nullable()->comment('域名');
            $table->string('maclan')->nullable()->comment('有线MAC地址');
            $table->string('macwl')->nullable()->comment('无线MAC地址');
            $table->string('ipv4lan')->nullable()->comment('有线ipv4');
            $table->string('ipv4wl')->nullable()->comment('无线ipv4');
            $table->string('ipv6lan')->nullable()->comment('有线ipv6');
            $table->string('ipv6wl')->nullable()->comment('无线ipv6');
            $table->string('remadmip')->nullable()->comment('远程管理IP');
            $table->string('panelport')->nullable()->comment('面板端口');
            $table->integer('switchid')->nullable()->unsigned()->comment('交换机编号');
            $table->string('switchport')->nullable()->comment('接入交换机端口号');
            $table->integer('ports')->nullable()->unsigned()->comment('网络端口数量');

            $table->string('origin')->nullable()->comment('origin');
            $table->string('purchprice')->nullable()->comment('购买价格');


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
