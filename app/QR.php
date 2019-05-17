<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QR extends Model
{
    protected $primaryKey = 'qr_id';
	protected $table = 'qr';
    protected $fillable = [
    	'qr_path',
    ];
}
