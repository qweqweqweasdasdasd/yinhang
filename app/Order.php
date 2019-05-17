<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'o_id';
	protected $table = 'order';
    protected $fillable = [
    	'bank_account','order_no','money','status','addtime','username','desc','bank_type'
    ];
}
