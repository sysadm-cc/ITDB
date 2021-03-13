<?php

namespace App\Http\Controllers\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\Item\Item_statustypes;

use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\Renshi\jiaban_applicantExport;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class ItemController extends Controller
{
	/**
	 * 列出 statustypes 页面
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemStatustypes()
	{
	// 获取JSON格式的jwt-auth用户响应
	$me = response()->json(auth()->user());

	// 获取JSON格式的jwt-auth用户信息（$me->getContent()），就是$me的data部分
	$user = json_decode($me->getContent(), true);
	// 用户信息：$user['id']、$user['name'] 等

	// 获取系统配置
	$config = Config::pluck('cfg_value', 'cfg_name')->toArray();

	// 获取 statustypes 信息
	$info_todo = Item_statustypes::select('id', 'statusdesc', 'created_at', 'updated_at', 'deleted_at')
		// ->where('uid_of_auditor', $user['uid'])
		// ->whereBetween('status', [1, 98])
		// ->where('archived', false)
		->limit(100)
		->orderBy('created_at', 'desc')
		->get()->toArray();

	$share = compact('config', 'user', 'info_todo');
	return view('item.statustypes', $share);
	}




	



	
}
