<?php 
namespace App\Repositories;

use App\Order;

/**
 * 管理仓库
 */
class OrderRepository
{
    //显示所有的订单数据
    public function getOrders($d)
    {
        $order = Order::where(function($query) use($d){
                        if( !empty($d['bank_account']) ){
                            $query->where('bank_account',$d['bank_account']);
                        }
                        if( !empty($d['order_no']) ){
                            $query->where('order_no',$d['order_no']);
                        }
                        if( !empty($d['username']) ){
                            $query->where('username',$d['username']);
                        }
                    })
                    ->orderBy('o_id','desc')
                    ->paginate(13);

        return $order;
    }

    //显示订单数据的总计
    public function count($d)
    {
        return Order::where(function($query) use($d){
                if( !empty($d['bank_account']) ){
                    $query->where('bank_account',$d['bank_account']);
                }
                if( !empty($d['order_no']) ){
                    $query->where('order_no',$d['order_no']);
                }
                if( !empty($d['username']) ){
                    $query->where('username',$d['username']);
                }
            })->count();
    }

    //显示订单数据的总计
    public function total($d)
    {
        return Order::where(function($query) use($d){
                if( !empty($d['bank_account']) ){
                    $query->where('bank_account',$d['bank_account']);
                }
                if( !empty($d['order_no']) ){
                    $query->where('order_no',$d['order_no']);
                }
                if( !empty($d['username']) ){
                    $query->where('username',$d['username']);
                }
            })->sum('money');
    }

    //获取到一条订单信息
    public function get_order($id)
    {
        return Order::find($id);
    }
}