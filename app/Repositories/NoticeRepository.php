<?php 
namespace App\Repositories;

use App\Notice;

/**
 * 提示仓库
 */
class NoticeRepository
{
    //获取到一条数据
    public function noticeFind($id)
    {
        return Notice::find($id);
    }
}