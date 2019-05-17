<?php

namespace App\Http\Controllers\Server;

use App\Sale;
use App\Order;
use App\UserBank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisifangController extends Controller
{
    //第四方运行逻辑
    //会员账号
    //存款金额
    //支付的订单号
    public function run_disifang($username,$trade_amount,$number,$bank_account,$budan='')
    {
        app('log')->info('进入了第四方类:'.$username.'--'.$trade_amount.'--'.$number);
        //获取到优惠比例金额
        if($budan){
            $budan_order_no = 'budan'.mt_rand(10000,99999).$number;
            $res = json_decode($this->disifang_Http($username,$this->get_yh_amount('1',$trade_amount),$budan_order_no));
        }else{
            //请求第四方接口
            $res = json_decode($this->disifang_Http($username,$this->get_yh_amount('1',$trade_amount),$number));
        }
        
        app('log')->info(json_encode($res));
        //回调函数 错误信息
        if($res->status == 'true'){
            //支付成功 重复支付
            if(UserBank::where('bank_code',$bank_account)->value('cert_status') != 1){
                UserBank::where('bank_code',$bank_account)->update(['cert_status'=>1,'cert_monney'=>$trade_amount]);     //用户与银行对应 1 验证ok 
            }
            //补单
            if($budan){
                app('log')->info( '补单成功:'.$username.'-'.$trade_amount.'-'.date('Y-m-d H:i:s',time()) .'-'. $budan_order_no);
                return Order::where('order_no',$number)->update(['status'=>3,'bio'=>'补单成功:'.$username.'-'.$budan_order_no.'-'.$trade_amount.'-'.date('Y-m-d H:i:s',time())]);
            }
            app('log')->info( '上分成功:'.$username.'-'.$trade_amount.'-'.date('Y-m-d H:i:s',time()) );
            //不补单
            return Order::where('order_no',$number)->update(['status'=>3,'bio'=>'上分成功:'.$username.'-'.$trade_amount.'-'.date('Y-m-d H:i:s',time())]);
            //return ['code'=>config('code.response.success')];
        }
        if($res->status == 'false'){
            //支付失败
            app('log')->info( '支付失败:'.$username.'-'.$trade_amount.'-'.date('Y-m-d H:i:s',time()).$res['msg'] );
            return Order::where('order_no',$number)->update(['status'=>4,'bio'=>$res->msg]);
            //return ['code'=>config('code.response.error'),'error'=>$res->msg];
        }
    }

    //获取到优惠比例金额
    //存款方式 pay_type 1 银行存款
    //存款金额 trade_amount
    public function get_yh_amount($pay_type='1',$trade_amount='1')
    {
        //select yh_per title == $pay_type && status == 1
        $yh_per = Sale::where(['title'=>$pay_type,'status'=>1])->value('yh_per');
        if($yh_per){
            return (($yh_per * $trade_amount)+$trade_amount);
        }
        return $trade_amount;
    }

    //请求第四方接口
    public function disifang_Http($username,$trade_amount,$number)
    {
        $app_id = '1546937910197';      //app_id 
        $key = 'edbb111d5770438dbacd9b93570ecf81';  //密钥

        $url = "http://ourf4pay.agcjxnow.com/fourth_payment_platform/pay/addMoney";
        
        $sign = 'account='.$username.'&app_id='.$app_id.'&money='.$trade_amount.'&order_no='.$number.'&status=0&tradeType=1&type=1&key='.$key;
        $sign = md5($sign);
        //数据
        $array = [
            'account'=>$username,
            'app_id'=>$app_id,
            'money'=>$trade_amount,
            'order_no'=>$number,
            'remark'=>'okok111',
            'sign'=>$sign,    //32位小写MD5签名值，GB2312编码
            'status'=>'0',    //0：支付成功 1：支付失败
            'tradeType'=>'1', //支付类型  0：网银 1 微信 2支付宝 3QQ
            'type'=>'1'      //支付终端  0：PC 1：手机 2：APP
        ];
        $array = http_build_query($array);
        //请求发送数据
        return $this->_httpPost($url,$array);
    }

    //检查用户是否在平台上
    public function check_username($username = null){
        if(!$username){
            return array('status'=>'false', 'msg'=>'第三方账号不能为空');
        }

        $app_id = '1546937910197';   //appid
        $key = 'edbb111d5770438dbacd9b93570ecf81';  //秘钥
        $url = 'http://ourf4pay.agcjxnow.com/fourth_payment_platform/pay/checkAccount';

        $sign = 'account='.$username.'&app_id='.$app_id.'&key='.$key;
        $sign = md5($sign);

        $array = [
            'account' => $username,
            'app_id' =>$app_id,
            'sign' => $sign
        ];
        $array = http_build_query($array);
        $info = $this->_httpPost($url, $array);
        $info = json_decode($info, true);  
   
        return $info;

    }

    //post 请求
    public function _httpPost($url = '',$requestData = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; zh-CN) AppleWebKit/535.12 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/535.12");
        $response = curl_exec($ch);
        //dd($ch);
        if (curl_errno($ch)) {
            echo 'Curl error:' . curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }
}
