<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Libs\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ManagerRepository;

class IndexController extends Controller
{
    //管理员仓库
    protected $managerRepository;

    //实例化管理员
    public function __construct(ManagerRepository $managerRepository)
    {
        $this->managerRepository = $managerRepository;
    }
    
    //管理后台--首页显示
    public function index()
    {
    	return view('admin.index.index',compact('manager')); 
    }

    //管理后台--welcome
    public function welcome()
    {
    	$mg_id = Auth::guard('back')->user()->mg_id;
        $manager = $this->managerRepository->get_login_manager_info($mg_id);
    	
    	return view('admin.index.welcome',compact('manager'));
    }

    //测试
    public function test()
    {
        $res = Helper::import_db_existd('123','1','123');
        //Helper::write_in_redis_unique('123','1','123');
        var_dump($res);
    }
}
