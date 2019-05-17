<?php

namespace App\Http\Controllers\Home;

use App\QR;
use App\Budan;
use App\WOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckbudanRequest;

class WechatController extends Controller
{
    //微信支付的页面
    public function wechat()
    {
        $qr = QR::find(1);  //只获取到第一条二维码
        return view('home.wechat.index',compact('qr'));
    }

    //微信补单的页面
    public function budan()
    {
        return view('home.wechat.budan');
    }

    //微信补单验证
    public function dobudan(CheckbudanRequest $request)
    {
        //根据订单获取到一条数据  
        $w_order = WOrder::where('trade_no',$request->get('w_trade_no'))->first();
        if(is_null($w_order)){
            return ['code'=>config('code.response.error'),'msg'=>'获取不到该订单号信息!'];
        }

        //该订单的金额是否与填写的一致
        if($request->get('money') != $w_order->money ){
            return ['code'=>config('code.response.error'),'msg'=>'您的存款金额与填写的金额不一致哦!'];
        }
      
      	//判断是否为待处理状态
        if( $w_order->status == 1){
            return ['code'=>config('code.response.error'),'msg'=>'订单代理处理请稍等!'];
        }

        //查询订单的状态是否已支付
        if( $w_order->status == 4 || $w_order->status == 5 ){
            return ['code'=>config('code.response.error'),'msg'=>'这个订单已经到账了哦!'];
        }

        //会员账号是否存在
        $disifang = new \App\Http\Controllers\Server\DisifangController();  //实例化
        $res = $disifang->check_username($request->get('input_name'));
        if($res['status'] == 'false'){
            //查询无效会员,请查看是否填错了会员账号 
            return ['code'=>config('code.response.error'),'msg'=>'查询无效会员,请查看是否填错了会员账号!'];
        }
        $order_no = $request->get('w_trade_no') . 'budan' . mt_rand(100000,999999);
        //操作自动上分
        $res = json_decode($disifang->disifang_Http( $request->get('input_name'), str_replace(',','',$request->get('money')), $order_no ));
        app('log')->info($res->status);
        app('log')->info($res->msg);
        //返回失败
        if($res->status == 'false'){
            //服务器内部问题  微信订单
            app('log')->info('补单false');
            WOrder::where('trade_no',$request->get('w_trade_no'))->update(['status'=>3,'desc'=>$res->msg]);
            return 'error';
        }
        //返回成功
        if($res->status == 'true'){
            app('log')->info('支付成功');
            //支付成功  订单唯一性
            $r = WOrder::where('trade_no',$request->get('w_trade_no'))->update(['status'=>5,'desc'=>$request->get('w_trade_no').'-补单成功到账--时间:'.date('Y-m-d H:i:s') ]);
            // 微信补单 录入系统
            Budan::create([
                'input_name'=>$request->get('input_name'),
                'money'=>$request->get('money'),
                'w_trade_no'=>$request->get('w_trade_no'),
                'status'=>5,
                'desc'=>'临时订单-'.$order_no
            ]);
            return ['code'=>config('code.response.success'),'msg'=>'补单成功!'];
        }

    }
}
