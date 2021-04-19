<?php

namespace App\Http\Controllers\Soft;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\Soft\Softs;

use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\Renshi\jiaban_applicantExport;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class SoftsController extends Controller
{
	/**
	 * 显示页面 itemtypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function softSofts()
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
	return view('soft.softs', $share);
	}


	/**
	 * 显示页面 add
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function softAdd()
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
	return view('soft.add', $share);
	}


    /**
     * 新建 softCreate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function softCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		// $nowtime = date("Y-m-d H:i:s",time());
		$title = $request->input('add_title');
		$agentid = $request->input('add_agentid_select');
		$invoiceid = $request->input('add_invoiceid_select');
		$type = $request->input('add_type');
		$version = $request->input('add_version');
		$purchasedate = $request->input('add_purchasedate');
		$quantity = $request->input('add_quantity');
		$licenseinfo = $request->input('add_licenseinfo');
		$comments = $request->input('add_comments');
		
		try	{
			$result = Softs::create([
				'title' => $title,
				'agentid' => $agentid,
				'invoiceid' => $invoiceid,
				'type' => $type,
				'version' => $version,
				'purchasedate' => $purchasedate,
				'quantity' => $quantity,
				'licenseinfo' => $licenseinfo,
				'comments' => $comments,
			]);
			Cache::flush();
		}
		catch (\Exception $e) {
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}

		return $result;
    }


	/**
	 * 读取记录 softs
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function softGets(Request $request)
	{
	if (! $request->ajax()) return null;

	$url = request()->url();
	$queryParams = request()->query();
	
	$perPage = $queryParams['perPage'] ?? 10000;
	$page = $queryParams['page'] ?? 1;
	
	//对查询参数按照键名排序
	ksort($queryParams);

	//将查询数组转换为查询字符串
	$queryString = http_build_query($queryParams);

	$fullUrl = sha1("{$url}?{$queryString}");
	
	
	//首先查寻cache如果找到
	if (Cache::has($fullUrl)) {
		$result = Cache::get($fullUrl);    //直接读取cache
	} else {                                   //如果cache里面没有
		$result = Softs::select()
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}


	/**
	 * 删除记录 softDelete
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function softDelete(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('tableselect');

		try	{
			$result = Softs::whereIn('id', $id)->delete();
		}
		catch (\Exception $e) {
			// echo 'Message: ' .$e->getMessage();
			$result = 0;
		}
		
		Cache::flush();
		return $result;
	}




	





	
}
