<?php 
namespace App\Repositories;

use App\Sale;
/**
 * 优惠仓库
 */
class SaleRepository
{
    //获取到所有的优惠配置文件  
    public function getSale()
    {
        return Sale::orderBy('sort','desc')->get();
    }
}