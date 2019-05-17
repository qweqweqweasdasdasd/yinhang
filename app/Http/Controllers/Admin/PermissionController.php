<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\PermissionRepository;
use App\Http\Requests\StorePermissionRequest;

class PermissionController extends Controller
{
    //公用仓库
    protected $baseRepository;
    protected $permissionRepository;

    //构造函数
    public function __construct(BaseRepository $baseRepository,PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->baseRepository = $baseRepository;
        $this->baseRepository->model = 'permission';
        $this->baseRepository->id = 'ps_id';
    }
   
    /**
     * 显示列表
     */
    public function index()
    {
        $permission_tree = $this->permissionRepository->get_permission_tree();
        $count = (int)(count($permission_tree));

        return view('admin.permission.index',compact('permission_tree','count'));
    }

    /**
     * 显示创建页面
     */
    public function create()
    {
        $permission_tree = $this->permissionRepository->get_permission_tree();

        return view('admin.permission.create',compact('permission_tree'));
    }

    /**
     * 保存数据
     */
    public function store(StorePermissionRequest $request)
    {
        //判断权限名称是否重复
        if($this->permissionRepository->permission_unique($request->all())){
            return ['code'=>config('code.response.error'),'error'=>'权限名称重复了!'];
        }

        $this->permissionRepository->permission_sava($request->all());
        return ['code'=>config('code.response.success')];
    }

    /**
     * 显示编辑页面
     */
    public function edit($id)
    {
        $permission_tree = $this->permissionRepository->get_permission_tree();
        $info = $this->baseRepository->getOneById($id);

        return view('admin.permission.edit',compact('permission_tree','info'));
    }

    /**
     * 更新数据
     */
    public function update(StorePermissionRequest $request, $id)
    {
        //??修改权限之后所有的子权限跟着走
        $this->permissionRepository->permission_update($request->all());
        
        return ['code'=>config('code.response.success')];
    }

    /**
     * 删除
     */
    public function destroy($id)
    {
        //判断该权限是否有子权限
        if($this->permissionRepository->parent_permission($id)){
            return ['code'=>config('code.response.error'),'error'=>'该权限是父权限,请删除子权限!'];
        };

        $this->baseRepository->common_delete($id);
        return ['code'=>config('code.response.success')];
    }
}
