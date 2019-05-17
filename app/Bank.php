<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $primaryKey = 'u_id';
	protected $table = 'user';
    protected $fillable = [
    	'username','token','time_out','status','session_id'
    ];
}
