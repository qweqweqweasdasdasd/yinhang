<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'bank';
    protected $fillable = [
    	'u_id','bank_code','bank_name','bank_addr','type','cert_status','cert_monney','bio'
    ];

    //银行对用户是多对一的关系
    public function user()
    {
        return $this->belongsTo('App\Bank','u_id','u_id');
    }
}
