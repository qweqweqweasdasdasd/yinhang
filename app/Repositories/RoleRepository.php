<?php 
namespace App\Repositories;

use App\Role;
/**
 * 管理仓库
 */
class RoleRepository
{
	/*
    * 判断角色是否唯一
	* @return true 存在
	* @return false 不存在
	*/ 
	public function role_unique($r_name)
	{
		return !!(Role::where('r_name',$r_name)->count());
	}

	//角色的总数
	public function count()
	{
		return Role::count();
	}

	//角色数据
	public function get_role_data()
	{
		return Role::with('managers')->paginate(5);
	}

	//获取到一条数据
	public function getOneById($id)
	{
		return Role::find($id);
	}

	//获取到角色的名称和id 
	public function get_rname_rid()
	{
		return Role::pluck('r_name','r_id');
	}
}