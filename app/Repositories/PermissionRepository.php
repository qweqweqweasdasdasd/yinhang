<?php 
namespace App\Repositories;

use App\Role;
use App\Permission;
/**
 * 管理仓库
 */
class PermissionRepository extends BaseRepository
{
	//获取到权限的树形结构数据
	public function get_permission_tree()
	{
		return generateTree(Permission::get()->toArray());
	}

	//判断权限名称是否重复相同的父类权限下
	public function permission_unique($d)
	{
		return !!(Permission::where([ 'ps_name'=>$d['ps_name'],'ps_pid'=>$d['ps_pid'] ])->count());
	}

	//创建新的角色并保持数据
	public function permission_sava($d)
	{
		//获取到父级权限的level
		if($d['ps_pid'] == 0){
			$d['ps_level'] = 0;
		}else{
			$d['ps_level'] = (int)(Permission::where('ps_id',$d['ps_pid'])->value('ps_level')+1);
		}
		return Permission::create($d);
	}

	//更新角色权限信息
	public function permission_update($d)
	{
		//获取到父级权限的level
		if($d['ps_pid'] == 0){
			$d['ps_level'] = 0;
		}else{
			$d['ps_level'] = (int)(Permission::where('ps_id',$d['ps_pid'])->value('ps_level')+1);
		}
		return Permission::where('ps_id',$d['ps_id'])->update($d);
	}

	//判断该权限是否有子权限
	public function parent_permission($id)
	{
		return !!(Permission::where('ps_pid',$id)->count());
	}

	//获取到指定层次数据
	public function level_permission($level)
	{
		return Permission::where('ps_level',$level)->get();
	}

	//收集权限信息组装之后保存到数据库内
	public function permission_collection($d)
	{
		//收集信息 权限ids制作
        $ps_ids = implode(',',$d['quan']);
        //组装 ps_ca 数据
        $ps_cas = Permission::whereIn('ps_id',$d['quan'])
        			->select(\DB::raw("concat(ps_c,'-',ps_a) as ca"))
        			->whereIn('ps_level',['1','2'])
        			->pluck('ca');
        //组装字符
        $ps_ca = implode(',', $ps_cas->toArray());
        
        return Role::where('r_id',$d['r_id'])->update([
        			'ps_ids' => $ps_ids,
        			'ps_ca' => $ps_ca,
        		]);
	}
}