<?php 
namespace App\Repositories;

use Hash;
use App\Manager;
/**
 * 管理仓库
 */
class ManagerRepository extends BaseRepository
{
	//获取到管理数据
	public function get_manager_data($dataWhere)
	{
		return Manager::where(function($query) use($dataWhere){
						if( !empty($dataWhere['mg_name']) ){
							$query->where('mg_name','like',$dataWhere['mg_name'].'%');
						}

					})
					->orderBy('mg_id','asc')
					->with('role')
					->paginate(11);
	}

	//获取到管理员数据的总数
	public function get_manager_count()
	{
		return Manager::count();
	}

	//新建管理员信息
	public function saveManager($d)
	{
		$data = array_except($d,['password_confirmation']);
        $data['password'] = Hash::make($d['password']);

        return  Manager::create($data);
	}

	//修改管理员信息判断管理员密码是否重置了
	public function check_password_reseted($d)
	{
		if($d['password'] == Manager::where('mg_id',$d['mg_id'])->value('password')){
			return false;
		}
		return true;
	}

	//获取当前登录的管理信息
	public function get_login_manager_info($mg_id)
	{
		return Manager::find($mg_id);
	}
}