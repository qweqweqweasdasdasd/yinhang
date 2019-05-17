<?php

namespace App\Imports;

use App\Order;
use App\Libs\Helper;
use App\Jobs\PointToAccountJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;    //使用集合

class OrderImportCMB implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        //删除没有用的表头信息
        for ($i=0; $i < 13; $i++) { 
            $rows->forget($i);
        }
        foreach ($rows as $row) 
        {
            //不需要判断金额是否为空
            //$row[17] 对方银行卡号
            //$row[0,1] 支付时间
            //$row[5] 存款金额
            //对方银行卡号 存款金额 支付时间 md5加密 存在reids 唯一标识 (解决重复的问题)
            if( !empty($row[5]) ){  //金额不为空
                $time = $row[0].$row[1];    //交易时间 
                //app('log')->info(($row[17].'&'.$row[5].'&'.$row[1]));
                //app('log')->info(md5($row[17].'&'.$row[5].'&'.$row[1]));
                if(is_null(Helper::import_db_existd($row[17],$row[5],$row[1]))){    //没有存在导入的标识
                  
                    $username = Helper::by_bank_code_get_username($row[17]);
                    Helper::write_in_redis_unique($row[17],$row[5],$row[1]);
                    $order_no = date('YmdHis',time()).mt_rand(100000000,999999999); 
                    //找到会员账号 (保存数据库)
                    $order = Order::create([
                            'bank_account'=>$row[17],     //对方银行
                            'money'=>str_replace(',','',$row[5]),            //存款金额     小数点后黑掉
                            'addtime'=>$time,          //支付时间
                            'username'=>$username,       //从数据库查询支付的会员
                            'order_no'=>$order_no,       //订单
                            'bank_type'=>'3',            //CMB 招商银行
                            'status'=>'1',               //导入数据库
                        ]);
                    //app('log')->info($username.'生成订单');
                    //进入列队
                    dispatch(new PointToAccountJob($order));
                };
            }
        }
    }
}
