<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budan extends Model
{
    protected $primaryKey = 'b_id';
	protected $table = 'budan';
    protected $fillable = [
    	'input_name','money','w_trade_no','status','desc'
    ];
}
