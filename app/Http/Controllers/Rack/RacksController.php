<?php

namespace App\Http\Controllers\Rack;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\Rack\Racks;

use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\Renshi\jiaban_applicantExport;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class RacksController extends Controller
{
	/**
	 * 显示页面 itemtypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function rackRacks()
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
	return view('rack.racks', $share);
	}


	/**
	 * 显示页面 add
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function rackAdd()
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
	return view('rack.add', $share);
	}


    /**
     * 新建 rackCreate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rackCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		// $nowtime = date("Y-m-d H:i:s",time());
		$title = $request->input('add_title');
		$type = $request->input('add_type_select');
		$contactinfo = $request->input('add_contactinfo');
		$contacts = $request->input('add_contacts');
		$urls = $request->input('add_urls');
		
		try	{
			$result = Racks::create([
				'title' => $title,
				'type' => $type,
				'contactinfo' => $contactinfo,
				'contacts' => $contacts,
				'urls' => $urls,
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
	 * 读取记录 agents
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function rackGets(Request $request)
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
		$result = Racks::select()
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}






	
	/**
	 * 更新 itemtypes typedesc
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItemtypesUpdateTypedesc(Request $request)
	{
	if (! $request->isMethod('post') || ! $request->ajax()) return null;

	$id = $request->input('id');
	$typedesc = $request->input('typedesc');

	// 写入数据库
	try	{
		DB::beginTransaction();
		
		$result = Item_itemtypes::where('id', $id)
		->update([
			'typedesc' => $typedesc,
		]);

		$result = 1;
		Cache::flush();
	}
	catch (\Exception $e) {
		// echo 'Message: ' .$e->getMessage();
		DB::rollBack();
		// dd('Message: ' .$e->getMessage());
		return 0;
	}

	DB::commit();
	// Cache::flush();
	return $result;
	}
	

	/**
	 * 更新 itemtypes hassoftware
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItemtypesUpdateHassoftware(Request $request)
	{
	if (! $request->isMethod('post') || ! $request->ajax()) return null;

	$id = $request->input('id');
	$hassoftware = $request->input('hassoftware');

	// 写入数据库
	try	{
		DB::beginTransaction();
		
		$result = Item_itemtypes::where('id', $id)
		->update([
			'hassoftware' => $hassoftware,
		]);

		$result = 1;
		Cache::flush();
	}
	catch (\Exception $e) {
		// echo 'Message: ' .$e->getMessage();
		DB::rollBack();
		// dd('Message: ' .$e->getMessage());
		return 0;
	}

	DB::commit();
	// Cache::flush();
	return $result;
	}


	/**
	 * 删除 itemtypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItemtypesDelete(Request $request)
	{
	if (! $request->isMethod('post') || ! $request->ajax())  return false;

	$id = [$request->input('id')];
	$result = Item_itemtypes::whereIn('id', $id)->delete();
	Cache::flush();
	return $result;
	}




	
}
