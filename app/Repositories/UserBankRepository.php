<?php 
namespace App\Repositories;

use App\Bank;
use App\Order;
use App\UserBank;

//公用仓库
class UserBankRepository
{
    //给用户新增加一个银行卡信息
    public function create_bank_info($d)
    {
        return UserBank::create($d);
    }

    //判断相同的会员 相同的银行卡账号
    public function bankCode_user_exist($d)
    {
        return UserBank::where([
                // 'u_id'=>$d['u_id'],
                'bank_code'=>$d['bank_code']
            ])->count();
    }

    //获取到用户绑定的所有银行卡
    public function get_userbank_data($d)
    {
        return UserBank::where(function($query)use($d){
                    if( !empty($d['bank_code']) ){
                        $query->where('bank_code',$d['bank_code']);
                    }
                    if( !empty($d['u_id']) ){
                        $query->where('u_id',$d['u_id']);
                    }
                })
                ->orderBy('id','desc')
                ->with('user')
                ->paginate(13);
    }

    //获取到用户绑定的银行卡总数
    public function count($d)
    {
        return UserBank::where(function($query)use($d){
                    if( !empty($d['bank_code']) ){
                        $query->where('bank_code',$d['bank_code']);
                    }
                    if( !empty($d['u_id']) ){
                        $query->where('u_id',$d['u_id']);
                    }
                })
                ->count();
    }

    //获取到一条数据
    public function get_username_by_id($username)
    {
        return Bank::where('username',$username)->first()->u_id;
    }

    // 根据银行卡账号查询订单内到账失败的修改用户与银行对应表状态为 2
    public function check_budan_bank_code_reset_cert_status($d)
    {
        return Order::where('bank_account',$d['bank_code'])
                    ->where('status','<>',3)
                    ->count();
    }
}