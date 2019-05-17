<?php 
namespace App\Repositories;

use DB;

//公用仓库
class BaseRepository
{
	public $model = '';
	public $id = '';

	//公共新建数据
	public function common_insert($data)
	{
		$data['created_at'] = date('Y-m-d H:i:s',time());
		return DB::table($this->model)->insert($data);
	}

	//获取到指定的一条数据
	public function getOneById($id)
	{
		return DB::table($this->model)->where($this->id,$id)->first();
	}

	//更新指定的数据
	public function updateDataById($data,$id)
	{
		$data = array_except($data,[$this->id]);
		return DB::table($this->model)->where($this->id,$id)->update($data);
	}

	//删除指定的数据
	public function common_delete($id)
	{
		return DB::table($this->model)->where($this->id,$id)->delete();
	}

	//修改状态
	public function common_reset_status($id,$status,$field)
	{
		return DB::table($this->model)->where($this->id,$id)->update([$field=>$status]);
	}

}