<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptBank extends Model
{
    protected $primaryKey = 'b_id';
	protected $table = 'receipt_bank';
    protected $fillable = [
    	'bank_code','account_name','bank_name','bank_addr','start_use_status'
    ];
}
