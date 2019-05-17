<?php 
namespace App\Repositories;

use App\Bank;
use App\Order;
use App\UserBank;

/**
 * 管理仓库
 */
class BankRepository
{
	//通过会员更新数据
	public function update_by_username($d)
	{
		return Bank::where('username',$d['username'])->update([
			'token'=>$d['token'],
			'time_out'=>$d['time_out']
		]);
	}

	//重置token
	public function delete_token_null($token)
	{
		return Bank::where('token',$token)->update(['token'=>null]);
	}

	//是否通过验证
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

    //获取当前用户的所有银行卡信息
    public function get_user_banks($u_id)
    {
        return UserBank::where('u_id',$u_id)->get();
    }

    //获取到用户银行卡号 通过银行卡号获取到最近的订单(只获取一笔)
    public function get_last_order_by_bank_code($id)
    {
        $bank_code = $this->user_bank($id)->bank_code;
        
        return Order::where('bank_account',$bank_code)->orderBy('o_id','desc')->first();
    }

    //根据id获取到用户和银行卡对应关系
    public function user_bank($id)
    {
        return UserBank::find($id);
    }
    
}