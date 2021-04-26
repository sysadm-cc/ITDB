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

            // 属性
            $table->string('title')->comment('物品名称');
            $table->unsignedSmallInteger('itemtypeid')->nullable()->comment('物品类型编号');
            $table->boolean('ispart')->default(false)->comment('是否是部件');
            $table->boolean('rackmountable')->default(false)->comment('是否机架式');
            $table->unsignedInteger('agentid')->nullable()->comment('代理商编号');
            $table->string('model')->comment('型号');
            $table->unsignedTinyInteger('usize')->nullable()->comment('尺寸（单位U）');
            $table->string('assettag')->nullable()->comment('资产标签');
            $table->string('sn1')->nullable()->comment('序列号1');
            $table->string('sn2')->nullable()->comment('序列号2');
            $table->string('servicetag')->nullable()->comment('服务编号');
            $table->text('comments')->nullable()->comment('备注');

            // 使用
            $table->unsignedTinyInteger('status')->nullable()->comment('状态');
            $table->unsignedInteger('userid')->nullable()->comment('用户ID');
            $table->unsignedInteger('locationid')->nullable()->comment('位置/楼层');
            $table->unsignedInteger('areaid')->nullable()->comment('位置场所编号');
            $table->unsignedInteger('rackid')->nullable()->comment('机柜编号');
            $table->unsignedTinyInteger('rackposition')->nullable()->comment('所在机柜高度');
            $table->unsignedTinyInteger('rackdepth')->nullable()->comment('所在机柜深度');
            $table->string('functions')->nullable()->comment('功能用途');
            $table->text('maintenanceinstructions')->nullable()->comment('具体使用说明');
            
            // 保修
            $table->string('shop')->nullable()->comment('经销商');
            $table->float('purchaseprice', 8, 2)->nullable()->comment('购买价格');
            $table->dateTime('purchasedate')->nullable()->comment('购买日期');
            $table->unsignedSmallInteger('warrantymonths')->nullable()->comment('保修时长(月)');
            $table->text('warrantyinfo')->nullable()->comment('保修信息');

            // 配件
            $table->string('motherboard')->nullable()->comment('主板');
            $table->string('hd')->nullable()->comment('硬盘');
            $table->string('ram')->nullable()->comment('内存');
            $table->string('cpumodel')->nullable()->comment('CPU型号');
            $table->unsignedTinyInteger('cpuno')->nullable()->comment('CPU数量');
            $table->unsignedTinyInteger('cpucores')->nullable()->comment('每CPU内核数量');

            // 网络
            $table->string('dns')->nullable()->comment('域名');
            $table->string('maclan')->nullable()->comment('有线MAC地址');
            $table->string('macwl')->nullable()->comment('无线MAC地址');
            $table->string('ipv4lan')->nullable()->comment('有线ipv4');
            $table->string('ipv4wl')->nullable()->comment('无线ipv4');
            $table->string('ipv6lan')->nullable()->comment('有线ipv6');
            $table->string('ipv6wl')->nullable()->comment('无线ipv6');
            $table->string('remoteadminip')->nullable()->comment('远程管理IP');
            $table->unsignedInteger('switchid')->nullable()->comment('接入交换机编号');
            $table->unsignedTinyInteger('panelport')->nullable()->comment('配线架端口');
            $table->unsignedTinyInteger('switchport')->nullable()->comment('接入交换机端口号');
            $table->unsignedTinyInteger('ports')->nullable()->comment('网络端口数量');

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
