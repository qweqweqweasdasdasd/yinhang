<?php

namespace App\Http\Controllers\Admin;

use App\Libs\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginManagerRequest;

class LoginController extends Controller
{
    //跳转到登陆页面
    public function redirect()
    {
    	//如果是登录跳转到index.index ??
    	return redirect('/login');
    }

    //错误页面
    public function error()
    {
        return view('admin.common.error');
    }

    //显示登录页面
    public function show_login(Request $request)
    {
    	return view('admin.login.show');
    }

    //退出登录
    public function logout()
    {
        $mg_id = Auth::guard('back')->user()->mg_id;
        //写入退出时间
        Helper::write_mg_last_login_time($mg_id);
        Auth::guard('back')->logout();
        return redirect('/login');
    }

    //登录操作
    public function login(LoginManagerRequest $request)
    {
    	//auth认证
    	$name_passwrod = $request->only(['mg_name','password']);
    	if(!Auth::guard('back')->attempt($name_passwrod)){
    		return ['code'=>config('code.response.error'),'error'=>'管理员名称或者密码不对哦!'];
    	}

    	//判断管理员状态 
    	if(!Helper::check_manager_status($request->get('mg_name'))){
    		return ['code'=>config('code.response.error'),'error'=>'已被停用了!'];
    	};

    	//单点登录 
    	$mg_id = Auth::guard('back')->user()->mg_id;
    	$mg_session_id = $request->session()->getId();
    	Helper::single_sign_on($mg_id,$mg_session_id);
    	//记录ip
    	Helper::write_manager_ip($mg_id);
    	//记录次数
    	Helper::write_manager_login_count($mg_id);
    	
    	return ['code'=>config('code.response.success')];
    }
}
