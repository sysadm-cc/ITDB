<?php

namespace App\Http\Controllers\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\Item\Item_items;

use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\Renshi\jiaban_applicantExport;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class ItemAddController extends Controller
{
	/**
	 * 显示页面 add
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemAdd()
	{
		// 获取JSON格式的jwt-auth用户响应
		$me = response()->json(auth()->user());

		// 获取JSON格式的jwt-auth用户信息（$me->getContent()），就是$me的data部分
		$user = json_decode($me->getContent(), true);
		// 用户信息：$user['id']、$user['name'] 等

		// 获取系统配置
		$config = Config::pluck('cfg_value', 'cfg_name')->toArray();

		// 获取 itemtypes 信息
		// $info_todo = Item_itemtypes::select('id', 'statusdesc', 'created_at', 'updated_at', 'deleted_at')
		// 	// ->where('uid_of_auditor', $user['uid'])
		// 	// ->whereBetween('status', [1, 98])
		// 	// ->where('archived', false)
		// 	->limit(100)
		// 	->orderBy('created_at', 'desc')
		// 	->get()->toArray();
		$info_todo = [];

		$share = compact('config', 'user', 'info_todo');
		return view('item.add', $share);
	}


    /**
     * 新建 add
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function itemAddCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		// $nowtime = date("Y-m-d H:i:s",time());

		// 参数变量 - 属性
		$add_itemtype_select = $request->input('add_itemtype_select');
		$add_ispart = $request->input('add_ispart');
		$add_rackmountable = $request->input('add_rackmountable');
		$add_agent_select = $request->input('add_agent_select');
		$add_model = $request->input('add_model');
		$add_usize_select = $request->input('add_usize_select');
		$add_sn1 = $request->input('add_sn1');
		$add_sn2 = $request->input('add_sn2');
		$add_servicetag = $request->input('add_servicetag');
		$add_comments = $request->input('add_comments');
		$add_label = $request->input('add_label');

		// 参数变量 - 使用
		$add_status_select = $request->input('add_status_select');
		$add_user_select = $request->input('add_user_select');
		$add_location_select = $request->input('add_location_select');
		$add_area_select = $request->input('add_area_select');
		$add_rack_select = $request->input('add_rack_select');
		$add_rackposition_select1 = $request->input('add_rackposition_select1');
		$add_rackposition_select2 = $request->input('add_rackposition_select2');
		$add_function = $request->input('add_function');
		$add_maintenanceinstructions = $request->input('add_maintenanceinstructions');

		// 参数变量 - 保修
		$add_dateofpurchase = $request->input('add_dateofpurchase');
		$add_warrantymonths = $request->input('add_warrantymonths');
		$add_warrantyinfo = $request->input('add_warrantyinfo');

		// 参数变量 - 配件
		$add_harddisk = $request->input('add_harddisk');
		$add_ram = $request->input('add_ram');
		$add_cpumodel = $request->input('add_cpumodel');
		$add_cpus_select = $request->input('add_cpus_select');
		$add_cpucores_select = $request->input('add_cpucores_select');

		// 参数变量 - 网络
		$add_dns = $request->input('add_dns');
		$add_mac = $request->input('add_mac');
		$add_ipv4 = $request->input('add_ipv4');
		$add_ipv6 = $request->input('add_ipv6');
		$add_remoteadminip = $request->input('add_remoteadminip');
		$add_panelport = $request->input('add_panelport');
		$add_switch_select = $request->input('add_switch_select');
		$add_switchport = $request->input('add_switchport');
		$add_networkports_select = $request->input('add_networkports_select');

		// 参数变量 - 记账
		$add_shop = $request->input('add_shop');
		$add_purchaceprice = $request->input('add_purchaceprice');



// dd($add_harddisk);


		
		try	{
			$result = Item_items::create([

				// 参数变量 - 属性
				'itemtypeid' => $add_itemtype_select,
				'ispart' => $add_ispart,
				'rackmountable' => $add_rackmountable,
				'agentid' => $add_agent_select,
				'model' => $add_model,
				'usize' => $add_usize_select,
				'sn1' => $add_sn1,
				'sn2' => $add_sn2,
				'servicetag' => $add_servicetag,
				'comments' => $add_comments,
				'assettag' => $add_assettag,
                
				// 参数变量 - 使用
				'status' => $add_status_select,
				'userid' => $add_user_select,
				'locationid' => $add_location_select,
				'locareaid' => $add_area_select,
				'rackid' => $add_rack_select,
				'rackposition' => $add_rackposition_select1,
				'rackposdepth' => $add_rackposition_select2,
				'function' => $add_function,
				'maintenanceinfo' => $add_maintenanceinstructions,
                
				// 参数变量 - 保修
				'purchasedate' => $add_dateofpurchase,
				'warrantymonths' => $add_warrantymonths,
				'warrinfo' => $add_warrantyinfo,
                
				// 参数变量 - 配件
				'hd' => $add_harddisk,
				'ram' => $add_ram,
				'cpu' => $add_cpumodel,
				'cpuno' => $add_cpus_select,
				'corespercpu' => $add_cpucores_select,
                
				// 参数变量 - 网络
				'dnsname' => $add_dns,
				'macs' => $add_mac,
				'ipv4' => $add_ipv4,
				'ipv6' => $add_ipv6,
				'remadmip' => $add_remoteadminip,
				'panelport' => $add_panelport,
				'switchid' => $add_switch_select,
				'switchport' => $add_switchport,
				'ports' => $add_networkports_select,
                
				// 参数变量 - 记账
				'origin' => $add_shop,
				'purchprice' => $add_purchaceprice,				
			]);
			Cache::flush();
		}
		catch (\Exception $e) {
			// echo 'Message: ' .$e->getMessage();
			return 'Message: ' .$e->getMessage();
			$result = 0;
		}

		return $result;
    }


	
}
