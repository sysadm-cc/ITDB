<?php

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Config;
use App\Models\Admin\User;
use App\Models\File\Files;

use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\Renshi\jiaban_applicantExport;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class FilesController extends Controller
{
	/**
	 * 显示页面 itemtypes
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function fileFiles()
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
	return view('file.files', $share);
	}


	/**
	 * 显示页面 add
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function fileAdd()
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
	return view('file.add', $share);
	}


    /**
     * 新建 fileCreate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fileCreate(Request $request)
    {
		if (! $request->isMethod('post') || ! $request->ajax()) return false;

		// $nowtime = date("Y-m-d H:i:s",time());
		$title = $request->input('add_title');
		$type = $request->input('add_type_select');
		$originalfilename = $request->input('add_originalfilename');
		$remotefilename = $request->input('add_remotefilename');
		$uploader = $request->input('add_uploader');
		
		try	{
			Storage::move('tmp/'.$remotefilename, 'files/'.$remotefilename);

			$result = Files::create([
				'title' => $title,
				'type' => $type,
				'originalfilename' => $originalfilename,
				'remotefilename' => $remotefilename,
				'uploader' => $uploader,
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
	 * 读取记录 files
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function fileGets(Request $request)
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
		$result = Files::select()
			->limit(1000)
			->orderBy('created_at', 'asc')
			->paginate($perPage, ['*'], 'page', $page);

		Cache::put($fullUrl, $result, now()->addSeconds(10));
		}

	return $result;
	}


	/**
	 * 删除记录 fileDelete
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function fileDelete(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('tableselect');

		try	{
			$result = Files::whereIn('id', $id)->delete();
		}
		catch (\Exception $e) {
			// echo 'Message: ' .$e->getMessage();
			$result = 0;
		}
		
		Cache::flush();
		return $result;
	}


	/**
	 * 更新 fileUpdate
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function fileUpdate(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		$id = $request->input('id');
		$updated_at = $request->input('updated_at');
		$title = $request->input('title');
		$type = $request->input('type');
		$filename = $request->input('filename');
		$uploader = $request->input('uploader');
		
		// 判断如果不是最新的记录，不可被编辑
		// 因为可能有其他人在你当前表格未刷新的情况下已经更新过了
		$res = Files::select('updated_at')
			->where('id', $id)
			->first();
		$res_updated_at = date('Y-m-d H:i:s', strtotime($res['updated_at']));
		if ($updated_at != $res_updated_at) return 0;

		// 尝试更新
		try	{
			DB::beginTransaction();
			$result = Files::where('id', $id)
				->update([
					'title'			=> $title,
					'type'		=> $type,
					'filename'			=> $filename,
					'uploader'			=> $uploader,
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
	 * 上传 fileUpload
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function fileUpload(Request $request)
	{
		// Storage::deleteDirectory('tmp');
		
		if (! $request->isMethod('post') || ! $request->ajax()) return null;

		// 接收文件
		$fileCharater = $request->file('myfile');
		// dd($fileCharater->getClientOriginalName());
 
		$result = 1;

		if ($fileCharater->isValid()) { //括号里面的是必须加的哦
			//如果括号里面的不加上的话，下面的方法也无法调用的

			$originalname = $fileCharater->getClientOriginalName();
			$fullpath = Storage::putFile('tmp', $fileCharater);
			$f = explode('/', $fullpath);
			$remotefilename = $f[1];

			$result = $originalname . '|' . $remotefilename;

			//获取文件的扩展名 
			// $ext = $fileCharater->extension();
			// if ($ext != 'xls' && $ext != 'xlsx') {
			// 	$result = 0;
			// }

			//获取文件的绝对路径
			// $path = $fileCharater->path();

			//定义文件名
			// $filename = date('Y-m-d-h-i-s').'.'.$ext;
			// $filename = 'importmpoint.'.$ext;

			//存储文件。使用 storeAs 方法，它接受路径、文件名和磁盘名作为其参数
			// $path = $request->photo->storeAs('images', 'filename.jpg', 's3');
			// $fileCharater->storeAs('tmp', $filename);
		} else {
			$result = 0;
		}
		
		// 导入excel文件内容
		// try {
		// 	// 先清空表
		// 	Smt_mpoint::truncate();
			
		// 	$ret = Excel::import(new mpointImport, 'excel/'.$filename);
		// 	// dd($ret);
		// 	$result = 1;
		// } catch (\Exception $e) {
		// 	// echo 'Message: ' .$e->getMessage();
		// 	$result = 0;
		// } finally {
		// 	Storage::delete('excel/'.$filename);
		// }
		
		// Storage::move('tmp/'.$filename, 'files/'.$filename);

		return $result;
	}
	
	/**
	 * 上传 fileUploadRemove
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function fileUploadRemove(Request $request)
	{
		if (! $request->isMethod('post') || ! $request->ajax()) return null;
		$remotefilename = $request->input('remotefilename');
		$result = Storage::delete('tmp/'.$remotefilename);
		return $result ? 1 : 0;
	}




	
}
