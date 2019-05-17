<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WOrder extends Model
{
    protected $primaryKey = 'w_id';
	protected $table = 'w_order';
    protected $fillable = [
    	'username','trade_no','money','trade_time','desc','status','pay_type'
    ];
}
