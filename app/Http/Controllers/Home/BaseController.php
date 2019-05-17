<?php

namespace App\Http\Controllers\Home;

use App\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
	//登录用户
	public $login_user = '';

	public function __construct(Request $request)
	{
	}

	//获取到用户
	public function user_exist($username)
	{
		return  (Bank::where('username',$username)->first());
	}

    //生成唯一token
	public function create_user_access_token()
	{
		return md5(uniqid(microtime(true),true));
	}
}
