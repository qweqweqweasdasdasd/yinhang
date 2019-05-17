<?php 
namespace App\Repositories;

use App\Budan;
use App\WOrder;

//微信仓库
class WcurdRepository
{
    //订单查询
    public function getWorder($d)
    {
        return WOrder::where(function($query) use($d){
                    if( !empty($d['trade_no']) ){
                        $query->where('trade_no',$d['trade_no'])
                              ->orWhere('username',$d['trade_no']);
                    }
                    if( !empty($d['datemin']) && !empty($d['datemax']) && ($d['datemax'] > $d['datemin']) ){
                        $query->where('trade_time','>',($d['datemin'].' 00:00:00'))
                              ->where('trade_time','<',($d['datemax']).' 59:59:59');
                    }
                })
                ->orderBy('w_id','desc')
                ->paginate(13);
    }

    //订单的总数
    public function count_w_order($d)
    {
        return WOrder::where(function($query) use($d){
                    if( !empty($d['trade_no']) ){
                        $query->where('trade_no',$d['trade_no'])
                              ->orWhere('username',$d['trade_no']);
                    }
                    if( !empty($d['datemin']) && !empty($d['datemax']) && ($d['datemax'] > $d['datemin']) ){
                        $query->where('trade_time','>',($d['datemin'].' 00:00:00'))
                              ->where('trade_time','<',($d['datemax']).' 59:59:59');
                    }
                })
                ->count();
    }

    //补单查询
    public function getBudan($d)
    {
        return Budan::where(function($query) use($d){
                    if( !empty($d['trade_no']) ){
                        $query->where('w_trade_no',$d['trade_no'])
                              ->orWhere('input_name',$d['trade_no']);
                    }
                })
                ->orderBy('b_id','desc')
                ->paginate(13);
    }

    //补单的总数
    public function count_budan($d)
    {
        return Budan::where(function($query) use($d){
                    if( !empty($d['trade_no']) ){
                        $query->where('w_trade_no',$d['trade_no'])
                              ->orWhere('input_name',$d['trade_no']); 
                    }
                })->count();
    }
}