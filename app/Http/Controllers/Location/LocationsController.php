<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\Location\Locations;

use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\Renshi\jiaban_applicantExport;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class LocationsController extends Controller
{
	/**
	 * 显示页面 itemtypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function locationLocations()
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
	return view('location.locations', $share);
	}


	/**
	 * 显示页面 add
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function locationAdd()
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
	return view('location.add', $share);
	}


    /**
     * 新建 locationCreate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function locationCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		// $nowtime = date("Y-m-d H:i:s",time());
		$title = $request->input('add_title');
		$building = $request->input('add_building');
		$floor = $request->input('add_floor');
		$areas = $request->input('add_areas');
		
		try	{
			$result = Locations::create([
				'title' => $title,
				'building' => $building,
				'floor' => $floor,
				'areas' => $areas,
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
	 * 读取记录 locations
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function locationGets(Request $request)
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
		$result = Locations::select()
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}


	/**
	 * 更新 locationUpdate
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function locationUpdate(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');
		$title = $request->input('title');
		$building = $request->input('building');
		$floor = $request->input('floor');
		
		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Locations::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Locations::where('id', $id)
				->update([
					'title'			=> $title,
					'building'		=> $building,
					'floor'			=> $floor,
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
	 * 删除记录 locationDelete
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function locationDelete(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('tableselect');

		try	{
			$result = Locations::whereIn('id', $id)->delete();
		}
		catch (\Exception $e) {
			// echo 'Message: ' .$e->getMessage();
			$result = 0;
		}
		
		Cache::flush();
		return $result;
	}

	
	/**
	 * areas 子项更新 SubupdateAreas
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function SubupdateAreas(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$subid = $request->input('subid');
		$updated_at = $request->input('updated_at');

		$name = $request->input('name');
		$x1 = $request->input('x1');
		$y1 = $request->input('y1');
		$x2 = $request->input('x2');
		$y2 = $request->input('y2');

		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Locations::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		$nowtime = date("Y-m-d H:i:s",time());

		// 尝试更新json
		try	{
			DB::beginTransaction();

			// if (empty($buliangneirong) && empty($weihao) && empty($shuliang[1])) {
				// $result = DB::update('update smt_qcreports set bushihejianshuheji = ' . $bushihejianshuheji . ', ppm = ' . $ppm . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
			// } else {
				$sql = 'JSON_REPLACE(areas, ';
				$sql .= '\'$[' . $subid . '].name\', "' . $name . '", ';
				$sql .= '\'$[' . $subid . '].x1\', "' . $x1 . '", ';
				$sql .= '\'$[' . $subid . '].y1\', "' . $y1 . '", ';
				$sql .= '\'$[' . $subid . '].x2\', "' . $x2 . '", ';
				$sql .= '\'$[' . $subid . '].y2\', "' . $y2 . '")';

				$result = DB::update('update locations set areas = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
			// }
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
	 * areas 子项删除 SubDeleteAreas
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function SubDeleteAreas(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$subid = $request->input('subid');

		$sql = 'JSON_REMOVE(areas, \'$[' . $subid . ']\')';

		$nowtime = date("Y-m-d H:i:s",time());

		try	{
			$result = DB::update('update locations set areas = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
		}
		catch (\Exception $e) {
			// dd('Message: ' .$e->getMessage());
			$result = 0;
		}
		
		Cache::flush();
		// dd($result);
		return $result;
	}


	/**
	* Areas 子项添加 SubCreateAreas
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function SubCreateAreas(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$a['name'] = $request->input('name');
		$a['x1'] = $request->input('x1');
		$a['y1'] = $request->input('y1');
		$a['x2'] = $request->input('x2');
		$a['y2'] = $request->input('y2');

		// 确认json id
		$areas = '';
		foreach ($a as $key => $value) {
			$areas .= '"'. $key . '":"' . $value . '",';
		}
		$areas = substr($areas, 0, strlen($areas)-1);

		$sql = 'JSON_MERGE_PRESERVE(areas, \'[{' . $areas . '}]\')';
		$nowtime = date("Y-m-d H:i:s",time());

		// 尝试更新（追加json）
		try	{
			DB::beginTransaction();
			$result = DB::update('update locations set areas = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
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
