<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\RoleRepository;
use App\Http\Requests\StoreRoleRequest;
use App\Repositories\PermissionRepository;

class RoleController extends Controller
{
    //公用仓库
    protected $baseRepository;
    protected $roleRepository;
    protected $permissionRepository;
    
    //构造函数
    public function __construct(BaseRepository $baseRepository,RoleRepository $roleRepository,PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->baseRepository = $baseRepository;
        $this->permissionRepository = $permissionRepository;
        $this->baseRepository->model = 'role';
        $this->baseRepository->id = 'r_id';
    }
   
    /**
     *  角色列表
     */
    public function index()
    {
        $role = $this->roleRepository->get_role_data();
        $count = $this->roleRepository->count();
        
        return view('admin.role.index',compact('role','count'));
    }

    /**
     * 显示创建角色页面
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * 保存新建角色
     */
    public function store(StoreRoleRequest $request)
    {
        if($this->roleRepository->role_unique($request->get('r_name'))){
            return ['code'=>config('code.response.error'),'error'=>'角色名称已经存在了!'];
        }
        $this->baseRepository->common_insert($request->all());
        return ['code'=>config('code.response.success')];
    }

    /**
     * 显示修改页面
     */
    public function edit($id)
    {
        $info = $this->baseRepository->getOneById($id);

        return view('admin.role.edit',compact('info'));
    }

    /**
     * 更新数据
     */
    public function update(StoreRoleRequest $request, $id)
    {
        $this->baseRepository->updateDataById($request->all(),$id);

        return ['code'=>config('code.response.success')];
    }

    /**
     * 删除指定的角色
     */
    public function destroy($id)
    {
        $this->baseRepository->common_delete($id);

        return ['code'=>config('code.response.error')];
    }

    /**
     * 权限分配
     */
    public function distribute(Request $request,$id)
    {
        if($request->isMethod('post')){
            //收集权限数据处理保存到数据库内
            $this->permissionRepository->permission_collection($request->all());
            return ['code'=>config('code.response.success')];
        }

        $info = $this->baseRepository->getOneById($id);
        $info_ps_ids = explode(',',$info->ps_ids);
        $permission_i = $this->permissionRepository->level_permission(0);
        $permission_ii = $this->permissionRepository->level_permission(1);
        $permission_iii = $this->permissionRepository->level_permission(2);
        return view('admin.role.distribute',compact(
            'info',
            'permission_i',
            'permission_ii',
            'permission_iii',
            'info_ps_ids'
        ));
    }
}
