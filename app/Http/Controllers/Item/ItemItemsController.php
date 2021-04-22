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

class ItemItemsController extends Controller
{
	/**
	 * 显示页面 items
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItems()
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
	return view('item.items', $share);
	}


	/**
	 * 读取记录 items
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItemsGets(Request $request)
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
		$result = Item_items::select()
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}


	/**
	 * 更新 itemItemsUpdateProperties
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItemsUpdateProperties(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');

		$title = $request->input('title');
		$itemtypeid = $request->input('itemtypeid');
		$ispart = $request->input('ispart');
		$rackmountable = $request->input('rackmountable');
		$agentid = $request->input('agentid');
		$model = $request->input('model');
		$usize = $request->input('usize');
		$assettag = $request->input('assettag');
		$sn1 = $request->input('sn1');
		$sn2 = $request->input('sn2');
		$servicetag = $request->input('servicetag');
		$comments = $request->input('comments');

		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Item_items::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Item_items::where('id', $id)
				->update([
					'title'			=> $title,
					'itemtypeid'	=> $itemtypeid,
					'ispart'		=> $ispart,
					'rackmountable'	=> $rackmountable,
					'agentid'		=> $agentid,
					'model'			=> $model,
					'usize'			=> $usize,
					'assettag'		=> $assettag,
					'sn1'			=> $sn1,
					'sn2'			=> $sn2,
					'servicetag'	=> $servicetag,
					'comments'		=> $comments,
				]);
		}
		catch (\Exception $e) {
			DB::rollBack();
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}
		DB::commit();
		Cache::flush();
		return $result;
	}

	/**
	 * 更新 itemItemsUpdateUsage
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItemsUpdateUsage(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');

		$status = $request->input('status');
		$userid = $request->input('userid');
		$locationid = $request->input('locationid');
		$areaid = $request->input('areaid');
		$rackid = $request->input('rackid');
		$rackposition = $request->input('rackposition');
		$rackdepth = $request->input('rackdepth');
		$functions = $request->input('functions');
		$maintenanceinstructions = $request->input('maintenanceinstructions');

		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Item_items::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Item_items::where('id', $id)
				->update([
					'status'					=> $status,
					'userid'					=> $userid,
					'locationid'				=> $locationid,
					'areaid'					=> $areaid,
					'rackid'					=> $rackid,
					'rackposition'				=> $rackposition,
					'rackdepth'					=> $rackdepth,
					'functions'					=> $functions,
					'maintenanceinstructions'	=> $maintenanceinstructions,
				]);
		}
		catch (\Exception $e) {
			DB::rollBack();
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}
		DB::commit();
		Cache::flush();
		return $result;
	}

	/**
	 * 更新 itemItemsUpdateWarranty
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItemsUpdateWarranty(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');
		$title = $request->input('title');
		$itemtypeid = $request->input('itemtypeid');
		$ispart = $request->input('ispart');
		$rackmountable = $request->input('rackmountable');
		$agentid = $request->input('agentid');
		$model = $request->input('model');
		$usize = $request->input('usize');
		$assettag = $request->input('assettag');
		$sn1 = $request->input('sn1');
		$sn2 = $request->input('sn2');
		$servicetag = $request->input('servicetag');
		$comments = $request->input('comments');

		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Item_items::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Item_items::where('id', $id)
				->update([
					'title'			=> $title,
					'itemtypeid'	=> $itemtypeid,
					'ispart'		=> $ispart,
					'rackmountable'	=> $rackmountable,
					'agentid'		=> $agentid,
					'model'			=> $model,
					'usize'			=> $usize,
					'assettag'		=> $assettag,
					'sn1'			=> $sn1,
					'sn2'			=> $sn2,
					'servicetag'	=> $servicetag,
					'comments'		=> $comments,
				]);
		}
		catch (\Exception $e) {
			DB::rollBack();
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}
		DB::commit();
		Cache::flush();
		return $result;
	}

	/**
	 * 更新 itemItemsUpdateMisc
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItemsUpdateMisc(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');
		$title = $request->input('title');
		$itemtypeid = $request->input('itemtypeid');
		$ispart = $request->input('ispart');
		$rackmountable = $request->input('rackmountable');
		$agentid = $request->input('agentid');
		$model = $request->input('model');
		$usize = $request->input('usize');
		$assettag = $request->input('assettag');
		$sn1 = $request->input('sn1');
		$sn2 = $request->input('sn2');
		$servicetag = $request->input('servicetag');
		$comments = $request->input('comments');

		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Item_items::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Item_items::where('id', $id)
				->update([
					'title'			=> $title,
					'itemtypeid'	=> $itemtypeid,
					'ispart'		=> $ispart,
					'rackmountable'	=> $rackmountable,
					'agentid'		=> $agentid,
					'model'			=> $model,
					'usize'			=> $usize,
					'assettag'		=> $assettag,
					'sn1'			=> $sn1,
					'sn2'			=> $sn2,
					'servicetag'	=> $servicetag,
					'comments'		=> $comments,
				]);
		}
		catch (\Exception $e) {
			DB::rollBack();
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}
		DB::commit();
		Cache::flush();
		return $result;
	}

	/**
	 * 更新 itemItemsUpdateNetwork
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function itemItemsUpdateNetwork(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');
		$title = $request->input('title');
		$itemtypeid = $request->input('itemtypeid');
		$ispart = $request->input('ispart');
		$rackmountable = $request->input('rackmountable');
		$agentid = $request->input('agentid');
		$model = $request->input('model');
		$usize = $request->input('usize');
		$assettag = $request->input('assettag');
		$sn1 = $request->input('sn1');
		$sn2 = $request->input('sn2');
		$servicetag = $request->input('servicetag');
		$comments = $request->input('comments');

		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Item_items::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Item_items::where('id', $id)
				->update([
					'title'			=> $title,
					'itemtypeid'	=> $itemtypeid,
					'ispart'		=> $ispart,
					'rackmountable'	=> $rackmountable,
					'agentid'		=> $agentid,
					'model'			=> $model,
					'usize'			=> $usize,
					'assettag'		=> $assettag,
					'sn1'			=> $sn1,
					'sn2'			=> $sn2,
					'servicetag'	=> $servicetag,
					'comments'		=> $comments,
				]);
		}
		catch (\Exception $e) {
			DB::rollBack();
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}
		DB::commit();
		Cache::flush();
		return $result;
	}



	
}
