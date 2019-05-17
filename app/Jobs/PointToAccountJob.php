<?php

namespace App\Jobs;

use App\Order;
use App\UserBank;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;    //https://www.kancloud.cn/baidu/laravel5/2843
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\Server\DisifangController;

class PointToAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //判断如果会员账号为空的话修改状态
        if($this->order->username == 'null'){
            //app('log')->info($this->order->username.'会员账号和银行账号无对应,修改状态');
            UserBank::where('bank_code',$this->order->bank_account)->update(['cert_status'=>2]);      //补单
            return $this->order::where('o_id',$this->order->o_id)->update(['status'=>2,'bio'=>'会员账号和银行账号无对应']);
        }
        try {
            //不为空的话 自动上分
            if($this->order->username != 'null'){
                $this->order::where('o_id',$this->order->o_id)->update(['status'=>6,'bio'=>'列队进入'.$this->order->username]);
                //实例化自动上分的逻辑
                $run_disifang = new \App\Http\Controllers\Server\DisifangController;

                $run_disifang->run_disifang($this->order->username,$this->order->money,$this->order->order_no,$this->order->bank_account);
            }
        } catch (\Exception $e) {
            app('log')->info( date('Y-m-d H:i:s') . '--' . $e->getMessage() );
        }
    }

}
