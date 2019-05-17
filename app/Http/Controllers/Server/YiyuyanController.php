<?php

namespace App\Http\Controllers\Server;

use App\WOrder;
use App\Libs\AESMcrypt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YiyuyanController extends Controller
{
    //易语言请求的接口  //微信扫码业务逻辑
    public function addMoney(Request $request)
    {
        app('log')->info("微信存款进来了:".date('Y-m-d H:i:s',time()));
        // $data = urldecode(file_get_contents("php://input"));  // 取出POST的原始请求数据
        // //数据是否为空
        // if( empty($data) ){
        //     return ['code'=>config('code.response.error'),'msg'=>'数据为空'];
        // }

        // $aes = new AESMcrypt($bit = 128, $key = 'hdfkmhgnbd45812s', $iv = '7451236985412563', $mode = 'cbc');
        // $data = $aes->decrypt($data);
        // $json = json_decode($data,true);
        
		// $trade_amount = str_replace(',','',$json['money']);
		// $username = trim($json['remarks']);
        // $number = $json['number'];
        //////////////////////////////////老唐安卓数据//////////////////////////////////
        //获取数据
        
        $dt = !empty($request->get('dt')) ? $request->get('dt'):'';     //支付时间
        $mark = !empty($request->get('mark')) ? $request->get('mark'):'';     //会员账号
        $money = !empty($request->get('money')) ? $request->get('money'):'';     //存款金额
        $no = !empty($request->get('no')) ? $request->get('no'):'';     //订单号
        $type = !empty($request->get('type')) ? $request->get('type'):'';     //支付类型
        $key = config('code.sign_key');     //约定key
        $sign = !empty($request->get('sign')) ? $request->get('sign'):'';     //客户端的签名
        
      	app('log')->info("微信存款进来了:" . date('Y-m-d H:i:s',time()).'-支付时间:'.$dt.'-会员账号:'.$mark.'-存款金额:'.$money.'-订单号:'.$no.'-key:'.$key.'-签名:'.$sign);
      	
        //判断签名是否正确
        if($sign != md5($dt . $mark . $money . $no . $type . $key)){
            app('log')->info("签名错误:".md5($dt . $mark . $money . $no . $type . $key));
           app('log')->info("支付时间:".$dt."-会员账号-".$mark."-存款金额-".$money."-订单号-".$no."-支付类型-".$type."-约定key-".$key."-客户端签名-".$sign);
            return 'success';     //发送异步通知失败 签名错误
        }
       
        
        //安全考虑::订单或者金额为空
        if(empty($no) || empty($money) ){
            app('log')->info("订单或者金额为空:"."会员账号-".$mark);
            return 'success';
        }
        //判断该订单状态(存款或者补单)
        //订单存在 订单状态为 4 (支付成功) 或者 5 补单成功 return success
        $w_order = WOrder::where('trade_no',$no)->count();
        if($w_order){
            app('log')->info("订单已经存在,订单号-".$no);
            //if($w_order->status == 4 || $w_order->status == 5){
            app('log')->info("另一个app发送的数据或者是补单成功了,订单号-".$no);
            return 'success';
            //}
        }
        //组装数据
        
        $data = [
            'money' => str_replace(',','',$money),
            'username'=> trim($mark),
            'trade_no'=> $no,
            'trade_time'=> date('Y-m-d H:i:s',$dt),
            'status'=>1,
            'pay_type'=>1   //微信
        ];
        //生成订单
        try {
            if(WOrder::create($data)){
                //用户的会员账号是否正确 
                if($this->check_user_exist($data) == 'error' ){
                    app('log')->info("username is error");
                    return 'success';
                }
                //调用第四方接口
                if($this->run_wecart($data) == 'error'){
                    app('log')->info("server is error");
                    return 'success';
                }
                return 'success';
            };
          //return 'error';
        } catch (\Exception $e) {
            return 'success';
        }
        //return ['code'=>config('code.response.success'),'data'=>$data];
        //////////////////////////////////老唐安卓数据////////////////////////////////// 
    }

    //调用第四方接口
    public function run_wecart($d = [])
    {
        // $d = [
        //     'money' => '0.1',
        //     'username' => 'test123',
        //     'trade_time'=> date('Y-m-d H:i:s',time()),
        //     'trade_no'=>'4200000246201901095670473163'
        // ];
        $disifang = new \App\Http\Controllers\Server\DisifangController();  //实例化
        app('log')->info('进入了第四方类:'.$d['username'].'--'.$d['money'].'--'.$d['trade_no']);
        $res = json_decode($disifang->disifang_Http($d['username'],str_replace(',','',$d['money']),$d['trade_no']));
        //return json_encode($res);
        //返回失败
        if($res->status == 'false'){
            //服务器内部问题
            WOrder::where('trade_no',$d['trade_no'])->update(['status'=>3,'desc'=>$res->msg]);
            return 'error';
        }
        //返回成功
        if($res->status == 'true'){
            //支付成功  订单唯一性
            WOrder::where('trade_no',$d['trade_no'])->update(['status'=>4,'desc'=>$d['username'].'-支付成功到账--时间:'.$d['trade_time'] ]);
            return 'success';
        }
    }

    //判断用户的会员账号是否正确
    public function check_user_exist($d = [])
    {
        $d = [
            'trade_amount' => '2',
            'username' => 'testqwe123',
            'trade_time'=> date('Y-m-d H:i:s',time()),
            'trade_no'=>'4200000240201901095859529476'
        ];
        $disifang = new \App\Http\Controllers\Server\DisifangController();  //实例化
        $res = $disifang->check_username($d['username']);
        return $res;
        if($res['status'] == 'false'){
            //查询无效会员,请查看是否填错了会员账号
            WOrder::where('trade_no',$d['trade_no'])->update(['status'=>2,'desc'=>'查询无效会员,请查看是否填错了会员账号']);    
            return 'error';
        }
        return 'succss';
    }
}
