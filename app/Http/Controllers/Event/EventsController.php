<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\Event\Events;

use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\Renshi\jiaban_applicantExport;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class EventsController extends Controller
{
	/**
	 * 显示页面 itemtypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function eventEvents()
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
	return view('event.events', $share);
	}


	/**
	 * 显示页面 add
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function eventAdd()
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
	return view('event.add', $share);
	}


    /**
     * 新建 eventCreate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eventCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		$nowtime = date("Y-m-d H:i:s",time());
		$events = $request->input('add_events');
		
		foreach ($events as $key => $value) {
			$events[$key]['created_at'] = $nowtime;
			$events[$key]['updated_at'] = $nowtime;
		}

		try	{
			// 此处如用insert可以直接参数为二维数组，但不能更新created_at和updated_at字段。
			// $result = events::create([
			// 	'name' => $events['name'],
			// 	'userid' => $events['userid'],
			// 	'department' => $events['department'],
			// 	'email' => $events['email'],
			// 	'gender' => $events['gender'],
			// ]);
			$result = Events::insert($events) ? 1 : 0;
			Cache::flush();
		}
		catch (\Exception $e) {
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}

		return $result;
    }


	/**
	 * 读取记录 events
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function eventGets(Request $request)
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
		$result = Events::select()
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}


	/**
	 * 删除记录 eventDelete
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function eventDelete(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('tableselect');

		try	{
			$result = Events::whereIn('id', $id)->delete();
		}
		catch (\Exception $e) {
			// echo 'Message: ' .$e->getMessage();
			$result = 0;
		}
		
		Cache::flush();
		return $result;
	}


	/**
	 * 更新 eventUpdate
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function eventUpdate(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');
		$name = $request->input('name');
		$userid = $request->input('userid');
		$department = $request->input('department');
		$email = $request->input('email');
		$gender = $request->input('gender');
		
		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Events::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Events::where('id', $id)
				->update([
					'name'			=> $name,
					'userid'		=> $userid,
					'department'	=> $department,
					'email'			=> $email,
					'gender'		=> $gender,
				]);
			// $result = 1;
		}
		catch (\Exception $e) {
			DB::rollBack();
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}
		DB::commit();
		Cache::flush();
		// dd($result);
		return $result;
	}

	





	
}
