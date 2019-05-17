<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BankRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Cache;
use App\Repositories\ReceiptRepository;

class BankController extends BaseController
{
    //银行数据仓库
    protected $username;
    protected $bankRepository;
    protected $baseRepository;
    protected $receiptRepository;

    //构造函数
    public function __construct(BankRepository $bankRepository,BaseRepository $baseRepository,ReceiptRepository $receiptRepository)
    {
        $this->bankRepository = $bankRepository;
        $this->baseRepository = $baseRepository;
        $this->receiptRepository = $receiptRepository;
        $this->baseRepository->model = 'user';
        $this->baseRepository->id = 'id';
    }

    //前台管理--银行登录    兼容 ios
    public function show_login(Request $request)
    {
        $str = explode(';', $request->header('cookie'))[0];
        $token = str_replace('=','',$str);
        if($this->bankRepository->is_login($token)){
            return redirect('/bank');
        };
    	return view('home.bank.show_login');
    }

    //前台管理--检查用户是否存在    1存在 2不存在
    public function check(Request $request)
    {
        $this->username = trim($request->get('username'));
        //发送接口请求
        $run_disifang = new \App\Http\Controllers\Server\DisifangController;
        $res = $run_disifang->check_username($this->username);
        if($res['status'] == 'false'){
            return ['code'=>2,'msg'=>$res['msg']];
        }
        //实例化一个发送请求的类
        if($res['status'] == 'true'){ //判断结果
           //记录ip地址
           $_token = $this->create_user_access_token();
           $data = [
                'username'=>$this->username,
                'token'=>$_token,
                'time_out'=>date('Y-m-d H:i:s',strtotime('+'.config('code.token_life_time_out').' day')),    
           ];

           if($this->user_exist($data['username'])){ //用户存在的情况
                $this->bankRepository->update_by_username($data);
                return ['code'=>1,'token'=>$_token];
           }else{
               $this->baseRepository->common_insert($data);
        	   return ['code'=>1,'token'=>$_token];
           }
        }
        return ['code'=>2,'msg'=>'会员不存在!'];
    }

    //前台管理--实时检查卡号是否改变
    public function bank_check(Request $request)
    {
        try {
            $bank = $this->receiptRepository->show_receipt_first();
            return ['code'=>config('code.response.success'),'data'=>$bank->bank_code];
        } catch (\Exception $e) {   
        }
        return ['code'=>config('code.response.error')];
    }

    //前台管理--银行转账页面
    public function bank(Request $request)
    {
        //显示收款的银行卡账号
        error_reporting(0);
        $bank = $this->receiptRepository->show_receipt_first();
        $str = explode(';', $request->header('cookie'))[0];
        $token = str_replace('=','',$str);
        $user = $this->receiptRepository->get_user($token);
        $user_banks_count = $this->bankRepository->get_user_banks($user->u_id)->count();
        
    	return view('home.bank.bank',compact('bank','user','user_banks_count'));
    }

    //前台管理--登出 兼容 ios 
    public function logout(Request $request)
    {
        //删除token
        $str = explode(';', $request->header('cookie'))[0];
        $token = str_replace('=','',$str);
        $this->bankRepository->delete_token_null($token);
    	return redirect('/bank/login');
    }

    //前台管理--获取到登陆用户的银行卡全部的信息 兼容 ios 
    public function get_user_banks(Request $request)
    {
        //获取当前用户的所有银行卡信息
        $str = explode(';', $request->header('cookie'))[0];
        $token = str_replace('=','',$str);
        $user = $this->receiptRepository->get_user($token);
        $user_banks = $this->bankRepository->get_user_banks($user->u_id);
        
        return ['list'=>$user_banks];
    }

    //前台管理--补单意思是什么 兼容 ios
    public function make_up(Request $request)
    {
        //获取到用户银行卡号 通过银行卡号获取到最近的订单(只获取一笔)
        $order = $this->bankRepository->get_last_order_by_bank_code($request->get('id'));
        $str = explode(';', $request->header('cookie'))[0];
        $token = str_replace('=','',$str);
        $user = $this->receiptRepository->get_user($token);
        //调用第四方类
        $run_disifang = new \App\Http\Controllers\Server\DisifangController;
        if($order->status == 3){
            return ['code'=>-1,'msg'=>'已经到账了哦'];
        }
        $run_disifang->run_disifang($user->username,$order->money,$order->order_no,$order->bank_account,'budan');
        return ['code'=>1,'msg'=>'成功到账'];
    }

    public function test()
    {
        //实例化自动上分的逻辑
        $run_disifang = new \App\Http\Controllers\Server\DisifangController;
     
        dump($run_disifang->run_disifang($username='test123',$trade_amount='2.3',$number='012131654654'));
    }

}
