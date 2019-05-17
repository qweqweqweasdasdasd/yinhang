<?php 
namespace App\Libs;

use Auth;
use App\UserBank;
use App\Manager;
use Illuminate\Support\Facades\Cache;


/**
 * 帮助类封装常用的方式
 */
class Helper
{
	/**
	 * 查询管理员是否状态
	 * @return int 1 正常
	 * @return int 0 停用
	 */
	public static function check_manager_status($mg_name)
	{
		return !!(Manager::where('mg_name',$mg_name)->value('mg_status'));
	}

	/**
	 * 单点的登录
	 */
	public static function single_sign_on($mg_id,$mg_session_id)
	{
		//判断数据是否为空
		$session_id = Manager::find($mg_id)->mg_session_id;
		if( is_null($session_id) ){
			return Manager::where('mg_id',$mg_id)->update(['mg_session_id'=>$mg_session_id]);
		}

		//删除文件内的sesson_id 
		//把新的session_id 写入
		if($session_id != $mg_session_id){
			try {
				unlink(storage_path()."/framework/sessions/{$session_id}");    //错误的使用了单引号
			} catch (\Exception $e) {
			}
			return Manager::where('mg_id',$mg_id)->update(['mg_session_id'=>$mg_session_id]);
		}
	}

	/**
	 * 获取到真实的ip 写入数据库
	 */
	public static function write_manager_ip($mg_id)
	{
		if(isset($_SERVER)){    
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }else{
            $realip = $_SERVER['REMOTE_ADDR'];
        }
	    }else{
	        //不允许就使用getenv获取  
	        if(getenv("HTTP_X_FORWARDED_FOR")){
	              $realip = getenv( "HTTP_X_FORWARDED_FOR");
	        }elseif(getenv("HTTP_CLIENT_IP")) {
	              $realip = getenv("HTTP_CLIENT_IP");
	        }else{
	              $realip = getenv("REMOTE_ADDR");
	        }
	    }
	    
	    return Manager::where('mg_id',$mg_id)->update(['mg_ip'=>$realip]);
	}

	//写入登录的次数
	public static function write_manager_login_count($mg_id)
	{
		return Manager::where('mg_id',$mg_id)->increment('mg_login_count',1);
	}

	//获取到管理员的id
	public static function get_manager_login_mg_id()
	{
		return Auth::guard('back')->user()->mg_id;
	}

	//写入退出的时间
	public static function write_mg_last_login_time($mg_id)
	{
		return Manager::where('mg_id',$mg_id)->update(['mg_last_login_time'=>date('Y-m-d H:i:s')]);
	}

	//md5加密 存在reids 唯一标识 (解决重复的问题)
	//6228480982488345819 	$row[8]		对方银行
	//100.00				$row[4]		存款金额
	//20190102 02:14:37		$row[2]		支付时间
	public static function write_in_redis_unique($bank_code,$money,$pay_time)
	{
		$reids_unique = md5($bank_code.'&'.$money.'&'.$pay_time); 
		
		return Cache::store('redis')->put($reids_unique,'T',config('code.order_unique_expiry'));	//code 配置文件内有配置
	}

	//判断导入数据库重复的情况
	//对方银行卡号	bank_code
	//存款金额	money
	//支付时间	pay_time
	public static function import_db_existd($bank_code,$money,$pay_time)
	{
		$reids_unique = md5($bank_code.'&'.$money.'&'.$pay_time);
		
		return Cache::store('redis')->get($reids_unique);
	}

	//银行卡号与会员账号的关系 都是唯一的
	//银行卡号
	public static function by_bank_code_get_username($bank_code)
	{
		try {
			return UserBank::where('bank_code',$bank_code)->first()->user->username;
		} catch (\Exception $e) {	
			return 'null';
		}
		 
	}

}