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
	 * 删除记录 contractDelete
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function contractDelete(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('tableselect');

		try	{
			$result = Contracts::whereIn('id', $id)->delete();
		}
		catch (\Exception $e) {
			// echo 'Message: ' .$e->getMessage();
			$result = 0;
		}
		
		Cache::flush();
		return $result;
	}


	/**
	 * 更新 contractUpdate
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function contractUpdate(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');
		$title = $request->input('title');
		$type = $request->input('type');
		$number = $request->input('number');
		$description = $request->input('description');
		$comments = $request->input('comments');
		$totalcost = $request->input('totalcost');
		$startdate = $request->input('startdate');
		$currentenddate = $request->input('currentenddate');
		
		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Contracts::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Contracts::where('id', $id)
				->update([
					'title'				=> $title,
					'type'				=> $type,
					'number'			=> $number,
					'description'		=> $description,
					'comments'			=> $comments,
					'totalcost'			=> $totalcost,
					'startdate'			=> $startdate,
					'currentenddate'	=> $currentenddate,
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
	 * renewals 子项更新 SubupdateRenewals
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function SubupdateRenewals(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$subid = $request->input('subid');
		$updated_at = $request->input('updated_at');

		$enddatebefore = $request->input('enddatebefore');
		$enddateafter = $request->input('enddateafter');
		$effectivedate = $request->input('effectivedate');
		$notes = $request->input('notes');

		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Contracts::select('updated_at')
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
				$sql = 'JSON_REPLACE(renewals, ';
				$sql .= '\'$[' . $subid . '].enddatebefore\', "' . $enddatebefore . '", ';
				$sql .= '\'$[' . $subid . '].enddateafter\', "' . $enddateafter . '", ';
				$sql .= '\'$[' . $subid . '].effectivedate\', "' . $effectivedate . '", ';
				$sql .= '\'$[' . $subid . '].notes\', "' . $notes . '")';

				$result = DB::update('update contracts set renewals = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
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
	 * renewals 子项删除 SubDeleteRenewals
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function SubDeleteRenewals(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$subid = $request->input('subid');

		$sql = 'JSON_REMOVE(renewals, \'$[' . $subid . ']\')';

		$nowtime = date("Y-m-d H:i:s",time());

		try	{
			$result = DB::update('update contracts set renewals = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
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
	* Renewals 子项添加 SubCreateRenewals
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function SubCreateRenewals(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$a['enddatebefore'] = $request->input('enddatebefore');
		$a['enddateafter'] = $request->input('enddateafter');
		$a['effectivedate'] = $request->input('effectivedate');
		$a['notes'] = $request->input('notes');

		// 确认json id
		$renewals = '';
		foreach ($a as $key => $value) {
			$renewals .= '"'. $key . '":"' . $value . '",';
		}
		$renewals = substr($renewals, 0, strlen($renewals)-1);

		$sql = 'JSON_MERGE_PRESERVE(renewals, \'[{' . $renewals . '}]\')';
		$nowtime = date("Y-m-d H:i:s",time());

		// 尝试更新（追加json）
		try	{
			DB::beginTransaction();
			$result = DB::update('update contracts set renewals = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
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
