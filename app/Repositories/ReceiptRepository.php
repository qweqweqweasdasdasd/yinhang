<?php 
namespace App\Repositories;

use App\Bank;
use App\ReceiptBank;
/**
 * 管理仓库
 */
class ReceiptRepository
{
	//判断收款银行是否有重复
	public function receiptUnique($d)
	{
		return !!(ReceiptBank::where('bank_code',$d['bank_code'])->count());
	}

	//获取到收款银行数据
	public function getReceipt()
	{
		return ReceiptBank::paginate(9);
	}

	//获取到收款银行总数
	public function count()
	{
		return ReceiptBank::count();
	}

	//获取到当前收款的银行卡信息展示出来
	public function show_receipt_first()
	{
		return ReceiptBank::where(['start_use_status'=>1])->first();
	}

	//获取到当前用户的信息
	public function get_user($token)
	{
		return Bank::where('token',$token)->first();
	}
}