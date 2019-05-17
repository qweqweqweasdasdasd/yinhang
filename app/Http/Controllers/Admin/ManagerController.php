<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ManagerRepository;
use App\Http\Requests\StoreManagerRequest;

class ManagerController extends Controller
{
    //管理员仓库
    protected $managerRepository;
    protected $baseRepository;
    protected $roleRepository;

    //构造函数
    public function __construct(ManagerRepository $managerRepository,BaseRepository $baseRepository,RoleRepository $roleRepository)
    {
        $this->managerRepository = $managerRepository;
        $this->baseRepository = $baseRepository;
        $this->roleRepository = $roleRepository;
        $this->baseRepository->model = 'manager';
        $this->baseRepository->id = 'mg_id';
    }
        
    /**
     *  管理员列表
     */
    public function index(Request $request)
    {
        $dataWhere['mg_name'] = !empty($request->get('mg_name'))? $request->get('mg_name') : '';
        $data = $this->managerRepository->get_manager_data($dataWhere);
        $count = $this->managerRepository->get_manager_count();
    
        return view('admin.manager.index',compact('data','count','dataWhere'));
    }

    /**
     * 显示创建管理页面
     */
    public function create()
    {
        //显示角色列表
        $rname_rid = $this->roleRepository->get_rname_rid();

        return view('admin.manager.create',compact('rname_rid'));
    }

    /**
     * 获取到数据
     */
    public function store(StoreManagerRequest $request)
    {
        $this->managerRepository->saveManager($request->all());

        return ['code'=>config('code.response.success')];
    }

    /**
     * 显示编辑
     */
    public function edit($id)
    {
        //显示角色列表
        $rname_rid = $this->roleRepository->get_rname_rid();
        $info = $this->baseRepository->getOneById($id);

        return view('admin.manager.edit',compact('rname_rid','info'));
    }

    /**
     * 更新数据
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        if($this->managerRepository->check_password_reseted($data)){   //修改了
            $data['password'] = Hash::make($data['password']);
        }
 
        $this->baseRepository->updateDataById($data,$id);
        return ['code'=>config('code.response.success')];
    }

    /**
     * 删除管理员信息
     */
    public function destroy($id)
    {
        return $this->baseRepository->common_delete($id);
    }
}
