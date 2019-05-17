<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'sale';
    protected $fillable = [
    	'title','yh_per','desc','status'
    ];
}
