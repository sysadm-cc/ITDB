<?php

namespace App\Http\Controllers\Contract;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\Contract\Contracts;
use App\Models\Contract\Contracttypes;

use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\Renshi\jiaban_applicantExport;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class ContractsController extends Controller
{
	/**
	 * 显示页面 contractContracts
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function contractContracts()
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
	return view('contract.contracts', $share);
	}


	/**
	 * 显示页面 contractContracttypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function contractContracttypes()
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
	return view('contract.contracttypes', $share);
	}


	/**
	 * 显示页面 add
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function contractAdd()
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
	return view('contract.add', $share);
	}


    /**
     * 新建 contractCreate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function contractCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		// $nowtime = date("Y-m-d H:i:s",time());
		$title = $request->input('add_title');
		$type = $request->input('add_type_select');
		$number = $request->input('add_number');
		$description = $request->input('add_description');
		$comments = $request->input('add_comments');
		$totalcost = $request->input('add_totalcost');
		$startdate = $request->input('add_startdate');
		$currentenddate = $request->input('add_currentenddate');
		$renewals = $request->input('add_renewals');

		try	{
			$result = Contracts::create([
				'title' => $title,
				'type' => $type,
				'number' => $number,
				'description' => $description,
				'comments' => $comments,
				'totalcost' => $totalcost,
				'startdate' => $startdate,
				'currentenddate' => $currentenddate,
				'renewals' => $renewals,
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
	 * 读取记录 contract
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function contractGets(Request $request)
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
		$result = Contracts::select()
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}

	
	/**
	 * 更新 contracttypes name
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function contracttypesUpdateName(Request $request)
	{
	if (! $request->isMethod('post') || ! $request->ajax()) return null;

	$id = $request->input('id');
	$name = $request->input('name');

	// 写入数据库
	try	{
		DB::beginTransaction();
		
		$result = Contracttypes::where('id', $id)
		->update([
			'name' => $name,
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
	 * 删除 contracttypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function contracttypesDelete(Request $request)
	{
	if (! $request->isMethod('post') || ! $request->ajax())  return false;

	$id = [$request->input('id')];
	$result = Contracttypes::whereIn('id', $id)->delete();
	Cache::flush();
	return $result;
	}



    /**
     * 新建 contracttypesCreate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function contracttypesCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		// $nowtime = date("Y-m-d H:i:s",time());
		$name = $request->input('name');

		try	{
			$result = Contracttypes::create([
				'name' => $name,
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
	 * 读取记录 contracttypesGets
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function contracttypesGets(Request $request)
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
		$result = Contracttypes::select()
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}


	
}
