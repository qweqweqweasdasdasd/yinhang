<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $primaryKey = 'n_id';
	protected $table = 'notice';
    protected $fillable = [
    	'n_title','content','pay_type'
    ];
}
