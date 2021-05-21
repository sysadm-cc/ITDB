<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin\Config;
use Cookie;

class JwtAuth
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

	// 请求前处理内容
	// return $next($request);

	$config = Config::pluck('cfg_value', 'cfg_name')->toArray();

	// 判断日期
	$dateofcurrent = date("Y-m-d H:i:s",time());
	$dateofsetup = date(decode4openssl(substr($config['SITE_EXPIRED_DATE'], 1)));

	if (!isDatetime($dateofsetup) || strtotime($dateofcurrent) > strtotime($dateofsetup)) {
		die(decode4openssl('uoq++Q9L/RSu6I3Y0aAky59ViFLabwXNRFtWkQnTt3DmbPxavhdj42J0bSpyaaLjireSFG63uaHIYU4DOV+qfoj/EYywGRP00VoBzdhSVnnggDXfhdQfNZQ0pRroEWG7UsunyhckGQxCUqzuN/D/RzpB0YSzNIwBXpazT8V5axEaEqBnNhKwA4wrbyEk87hXyU9/TfVSIwcixfv4a/MKSQ=='));
	}


	// 验证sitekey和appkey
	$config = Config::pluck('cfg_value', 'cfg_name')->toArray();
	$site_key = $config['SITE_KEY'];
	$app_key = substr(config('app.key'), 7);
	if ($app_key != $site_key) die();


	// 获取JSON格式的jwt-auth用户响应
	$me = response()->json(auth()->user());
	$user = json_decode($me->getContent(), true);

	// 判断数组为空，以此来判断是否有有效用户登录
	if (! sizeof($user)) {
		return $request->ajax() ? response()->json(['jwt' => 'logout']) : redirect()->route('login');
	} else {
		$token_local = Cookie::get('singletoken'.md5($app_key));
		$token_remote = $user['remember_token'];

		if (empty($token_remote) || $token_local != $token_remote) {
			Cookie::queue(Cookie::forget('token'));
			Cookie::queue(Cookie::forget('singletoken'.md5($app_key)));
			return $request->ajax() ? response()->json(['jwt' => 'logout']) : redirect()->route('login');
		}
	}


	// 保存请求内容
	$response = $next($request);


	// 请求后处理内容


	// 返回请求
	return $response;
	}
		

}
