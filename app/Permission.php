<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $primaryKey = 'ps_id';
	protected $table = 'permission';
    protected $fillable = [
    	'ps_name','ps_pid','ps_c','ps_a','ps_route','ps_level','desc'
    ];
}
