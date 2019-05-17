<?php

namespace App\Imports;

use App\Order;
use App\Libs\Helper;
use App\Jobs\PointToAccountJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;    //使用集合

class OrderImportCCB implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $rows->forget(0);   //删除表头
        foreach ($rows as $row)
        {
   
            //判断存款金额是否为 0 不为0 执行 
            if($row[4] != 0){ //金额不为0
                //对方银行卡号 存款金额 支付时间 md5加密 存在reids 唯一标识 (解决重复的问题)
                if(is_null(Helper::import_db_existd($row[8],$row[4],$row[2]))){    //没有存在导入的标识
                    $username = Helper::by_bank_code_get_username($row[8]);
                    Helper::write_in_redis_unique($row[8],$row[4],$row[2]);
                    $order_no = date('YmdHis',time()).mt_rand(100000000,999999999); 
                    //找到会员账号 (保存数据库)
                    $order = Order::create([
                            'bank_account'=>$row[8],     //对方银行
                            'money'=>str_replace(',','',$row[4]),            //存款金额     小数点后黑掉
                            'addtime'=>$row[2],          //支付时间
                            'username'=>$username,       //从数据库查询支付的会员
                            'order_no'=>$order_no,       //订单
                            'bank_type'=>'1',            //ccb 建设银行
                            'status'=>'1',               //导入数据库
                        ]);
                    app('log')->info('时间:' . date('Y-m-d H:i:s',time()). '银行导入excel' .json_encode($order));
                    //进入列队
                    dispatch(new PointToAccountJob($order));
                };
                
            }
        }
       
    }
}
