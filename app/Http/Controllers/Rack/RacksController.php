<?php

namespace App\Http\Controllers\Rack;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\Rack\Racks;
use App\Models\Location\Locations;

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
		$model = $request->input('add_model');
		$usize = $request->input('add_usize');
		$depth = $request->input('add_depth');
		$revnums = $request->input('add_revnums_select') ?? false;
		$locationid = $request->input('add_location_select');
		$areaid = $request->input('add_area_select');
		$label = $request->input('add_label');
		$comments = $request->input('add_comments');
		
		try	{
			$result = Racks::create([
				'title' => $title,
				'model' => $model,
				'usize' => $usize,
				'depth' => $depth,
				'revnums' => $revnums,
				'locationid' => $locationid,
				'areaid' => $areaid,
				'label' => $label,
				'comments' => $comments,
			]);
			Cache::flush();
		}
		catch (\Exception $e) {
			dd('Message: ' .$e->getMessage());
			$result = 0;
		}

		return $result;
    }


	/**
	 * 读取记录 racks
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
	 * 删除记录 rackDelete
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function rackDelete(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('tableselect');

		try	{
			$result = Racks::whereIn('id', $id)->delete();
		}
		catch (\Exception $e) {
			// echo 'Message: ' .$e->getMessage();
			$result = 0;
		}
		
		Cache::flush();
		return $result;
	}


	/**
	 * 更新 rackUpdate
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function rackUpdate(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');
		$title = $request->input('title');
		$model = $request->input('model');
		$usize = $request->input('usize');
		$depth = $request->input('depth');
		$revnums = $request->input('revnums');
		$locationid = $request->input('locationid');
		$label = $request->input('label');
		$comments = $request->input('comments');
		
		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Racks::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Racks::where('id', $id)
				->update([
					'title'			=> $title,
					'model'			=> $model,
					'usize'			=> $usize,
					'depth'			=> $depth,
					'revnums'		=> $revnums,
					'locationid'	=> $locationid,
					'label'			=> $label,
					'comments'		=> $comments,
				]);
			$result = 1;
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

	/**
	 * 添加时根据位置列出区域/房间 Location2Area
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function location2Area(Request $request)
	{
		if (! $request->ajax()) return null;

		$locationid = $request->input('locationid');
		
		if ($locationid == null || $locationid == null) return 0;
		
		try {
			$result = Locations::select('areas')
				->where('id', $locationid)
				->first();
		}
		catch (\Exception $e) {
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}

		return $result;

	}
	





	
}
