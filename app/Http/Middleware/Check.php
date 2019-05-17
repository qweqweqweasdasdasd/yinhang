<?php

namespace App\Http\Middleware;

use Closure;
use App\Bank;

class Check
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
        $str = explode(';', $request->header('cookie'))[0];
        $token = str_replace('=','',$str);
        if(!$this->is_login($token)){
            return redirect('/bank/login');
        }
        return $next($request);
    }

    //是否登录
    public function is_login($token)
    {
        //前台token不得为空
        if(empty($token)){
            //return ['code'=>0,'error'=>'no token!'];
            return false;
        }
        $user = Bank::where('token',$token)->first();
        //数据库是否查询到 无 跳转到登陆(登出)
        if( is_null($user) ){
            return false;
        };

        if( !$user->count() ){
            //return redirect('/bank/login');
            return false;
        };
        //数据库是否查询到 有 判断时间,是否过期
        if($user->time_out < date('Y-m-d H:i:s',time())){
            //过期删除 跳转到登陆
            Bank::where('token',$token)->update(['token'=>null]);
            //return ['code'=>0,'error'=>'失效!'];
            return false;
        }
        return true;
        
    }
}
