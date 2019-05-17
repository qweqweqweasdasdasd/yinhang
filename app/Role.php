<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'r_id';
	protected $table = 'role';
    protected $fillable = [
    	'r_name','ps_ids','ps_ca','desc'
    ];

    //角色与管理员关系 一对多 关系
    public function managers()
    {
    	return $this->hasMany('App\Manager','r_id','r_id');
    }
}
