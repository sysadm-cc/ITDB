<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\Agent\Agents;

use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\Renshi\jiaban_applicantExport;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class AgentsController extends Controller
{
	/**
	 * 显示页面 agentAgents
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function agentAgents()
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
	return view('agent.agents', $share);
	}


	/**
	 * 显示页面 add
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function agentAdd()
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
	return view('agent.add', $share);
	}


    /**
     * 新建 agentCreate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function agentCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		// $nowtime = date("Y-m-d H:i:s",time());
		$title = $request->input('add_title');
		$type = $request->input('add_type_select');
		$contactinfo = $request->input('add_contactinfo');
		$contacts = $request->input('add_contacts');
		$urls = $request->input('add_urls');

		try	{
			$result = Agents::create([
				'title' => $title,
				'type' => $type,
				'contactinfo' => $contactinfo,
				'contacts' => $contacts,
				'urls' => $urls,
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
	 * 读取记录 agentGets
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function agentGets(Request $request)
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
		$result = Agents::select()
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}


	/**
	 * 更新 agentUpdate
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function agentUpdate(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');
		$title = $request->input('title');
		$type = $request->input('type');
		$contactinfo = $request->input('contactinfo');

		// dd($id);
		// dd($updated_at);
		
		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Agents::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Agents::where('id', $id)
				->update([
					'title'			=> $title,
					'type'			=> $type,
					'contactinfo'	=> $contactinfo,
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
	 * contacts 子项更新 SubupdateContacts
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function SubupdateContacts(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$subid = $request->input('subid');

		$updated_at = $request->input('updated_at');

		$name = $request->input('name');
		$role = $request->input('role');
		$phonenumber = $request->input('phonenumber');
		$email = $request->input('email');
		$comments = $request->input('comments');

		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Agents::select('updated_at')
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
				$sql = 'JSON_REPLACE(contacts, ';
				$sql .= '\'$[' . $subid . '].name\', "' . $name . '", ';
				$sql .= '\'$[' . $subid . '].role\', "' . $role . '", ';
				$sql .= '\'$[' . $subid . '].phonenumber\', "' . $phonenumber . '", ';
				$sql .= '\'$[' . $subid . '].email\', "' . $email . '", ';
				$sql .= '\'$[' . $subid . '].comments\', "' . $comments . '")';

				$result = DB::update('update agents set contacts = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
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
	 * contacts 子项删除 SubDeleteContacts
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function SubDeleteContacts(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$subid = $request->input('subid');

		$sql = 'JSON_REMOVE(contacts, \'$[' . $subid . ']\')';

		$nowtime = date("Y-m-d H:i:s",time());

		try	{
			$result = DB::update('update agents set contacts = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
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
	 * contacts 子项更新 SubupdateUrls
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function SubupdateUrls(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$subid = $request->input('subid');

		$updated_at = $request->input('updated_at');

		$myurl = $request->input('myurl');
		$description = $request->input('description');

		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Agents::select('updated_at')
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
				$sql = 'JSON_REPLACE(urls, ';
				$sql .= '\'$[' . $subid . '].url\', "' . $myurl . '", ';
				$sql .= '\'$[' . $subid . '].description\', "' . $description . '")';

				$result = DB::update('update agents set urls = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
			// }
			$result = 1;
		}
		catch (\Exception $e) {
			DB::rollBack();
			dd('Message: ' .$e->getMessage());
			$result = 0;
		}
		DB::commit();
		Cache::flush();
		// dd($result);
		return $result;
	}


	/**
	 * contacts 子项删除 SubDeleteUrls
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function SubDeleteUrls(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$subid = $request->input('subid');

		$sql = 'JSON_REMOVE(urls, \'$[' . $subid . ']\')';

		$nowtime = date("Y-m-d H:i:s",time());

		try	{
			$result = DB::update('update agents set urls = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
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
	* Contacts 子项添加 SubCreateContacts
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function SubCreateContacts(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$a['name'] = $request->input('name');
		$a['role'] = $request->input('role');
		$a['phonenumber'] = $request->input('phonenumber');
		$a['email'] = $request->input('email');
		$a['comments'] = $request->input('comments');

		// 确认json id
		$contacts = '';
		foreach ($a as $key => $value) {
			$contacts .= '"'. $key . '":"' . $value . '",';
		}
		$contacts = substr($contacts, 0, strlen($contacts)-1);

	//    if ($count_of_contacts_append == 0) {
	// 	   $sql = '\'[{' . $contacts . '}]\'';
	//    } else {
			// $sql = 'JSON_MERGE(contacts, '[{"id":3, "weihao":"ZZZ", "shuliang":5, "jianchazhe":"张三"}]')';
			$sql = 'JSON_MERGE(contacts, \'[{' . $contacts . '}]\')';
	//    }
		// dd($sql);

		$nowtime = date("Y-m-d H:i:s",time());

		// 尝试更新（追加json）
		try	{
			DB::beginTransaction();
			$result = DB::update('update agents set contacts = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
			$result = 1;
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
	* Urls 子项添加 SubCreateUrls
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function SubCreateUrls(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$a['url'] = $request->input('myurl');
		$a['description'] = $request->input('description');

		// 确认json id
		$urls = '';
		foreach ($a as $key => $value) {
			$urls .= '"'. $key . '":"' . $value . '",';
		}
		$urls = substr($urls, 0, strlen($urls)-1);

		$sql = 'JSON_MERGE(urls, \'[{' . $urls . '}]\')';
		$nowtime = date("Y-m-d H:i:s",time());

		// 尝试更新（追加json）
		try	{
			DB::beginTransaction();
			$result = DB::update('update agents set urls = ' . $sql . ', updated_at = "' . $nowtime . '" where id = ?', [$id]);
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
	 * 删除记录 agentDelete
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function agentDelete(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('tableselect');

		try	{
			$result = Agents::whereIn('id', $id)->delete();
		}
		catch (\Exception $e) {
			// echo 'Message: ' .$e->getMessage();
			$result = 0;
		}
		
		Cache::flush();
		return $result;
	}

	
}
