<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    protected $primaryKey = 'mg_id';
	protected $table = 'manager';
	protected $rememberTokenName = '';
    protected $fillable = [
    	'mg_name','password','mg_phone','mg_sms','mg_session_id','r_id','mg_status','mg_ip','mg_login_count','mg_last_login_time','desc'
    ];

    use SoftDeletes;

    //管理员和角色 一对一 的 关系
    public function role()
    {
    	return $this->hasOne('App\Role','r_id','r_id');
    }
}
