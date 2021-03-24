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

class ItemStatustypesController extends Controller
{
	/**
	 * 显示页面 statustypes
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
	// $info_todo = Item_statustypes::select('id', 'statusdesc', 'created_at', 'updated_at', 'deleted_at')
	// 	// ->where('uid_of_auditor', $user['uid'])
	// 	// ->whereBetween('status', [1, 98])
	// 	// ->where('archived', false)
	// 	->limit(100)
	// 	->orderBy('created_at', 'desc')
	// 	->get()->toArray();
	$info_todo = [];

	$share = compact('config', 'user', 'info_todo');
	return view('item.statustypes', $share);
	}


	/**
	 * 读取记录 statustypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemStatustypesGets(Request $request)
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
		$result = Item_statustypes::select('id', 'statusdesc', 'created_at', 'updated_at', 'deleted_at')
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}

	
	/**
	 * 更新 statustypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemStatustypesUpdate(Request $request)
	{
	if (! $request->isMethod('post') || ! $request->ajax()) return null;

	$id = $request->input('id');
	$statusdesc = $request->input('statusdesc');

	// 写入数据库
	try	{
		DB::beginTransaction();
		
		$result = Item_statustypes::where('id', $id)
		->update([
			'statusdesc' => $statusdesc,
		]);

		$result = 1;
	}
	catch (\Exception $e) {
		// echo 'Message: ' .$e->getMessage();
		DB::rollBack();
		// dd('Message: ' .$e->getMessage());
		return 0;
	}

	DB::commit();
	Cache::flush();
	return $result;
	}


	/**
	 * 删除 statustypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemStatustypesDelete(Request $request)
	{
	if (! $request->isMethod('post') || ! $request->ajax())  return false;

	$id = [$request->input('id')];
	$result = Item_statustypes::whereIn('id', $id)->delete();
	Cache::flush();
	return $result;
	}


    /**
     * 新建 statustypes
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function itemStatustypesCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		// $nowtime = date("Y-m-d H:i:s",time());
		$statusdesc = $request->input('statusdesc');
		
		try	{
			$result = Item_statustypes::create([
				'statusdesc' => $statusdesc,
			]);
		}
		catch (\Exception $e) {
			// echo 'Message: ' .$e->getMessage();
			$result = 0;
		}

		return $result;
    }


	
}
