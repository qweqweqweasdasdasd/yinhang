<?php

/////////////////////////////////前台银行登录//////////////////////////////////
//前台管理--银行登录(显示登录)
Route::get('/bank/login','Home\BankController@show_login');
//前台管理--检查用户是否存在(登陆逻辑)
Route::post('/bank/check','Home\BankController@check');
//前台管理--登出
Route::get('/bank/logout','Home\BankController@logout');
//前台管理--显示公告
Route::get('/notice/show/{notice}','Admin\NoticeController@jiazai');

Route::group(['middleware'=>'check'],function(){
	//前台管理--银行转账页面
	Route::get('/bank','Home\BankController@bank');
	//前台管理--收款卡号检查
	Route::post('/bank/bank_check','Home\BankController@bank_check');
	//前台管理--补充用户的银行卡
	Route::post('/bank/create','Admin\UserBankController@create');
	//前台管理--获取到用户的银行信息
	Route::get('/bank/get_user_banks','Home\BankController@get_user_banks');
	//前台管理--补单操作
	Route::post('/bank/make_up','Home\BankController@make_up');
});


//测试第四方接口路由
//Route::get('/test/disifang','Home\BankController@test');
//优惠计算测试
//Route::get('/test','Server\DisifangController@get_yh_amount');
//测试MD5加密
//Route::get('/test','Admin\IndexController@test');
//测试第四方用户是否存在的接口
//Route::get('/test','Server\YiyuyanController@check_user_exist');
//测试调用第四方接口
//Route::get('/test','Server\YiyuyanController@run_wecart');

//测试易语言发来的数据
Route::post('/pay/addMoney','Server\YiyuyanController@addMoney');
//微信支付的页面
Route::get('/pay/wechat','Home\WechatController@wechat');
//微信补单的页面
Route::get('/pay/budan','Home\WechatController@budan');
//微信补单验证
Route::post('/pay/budan','Home\WechatController@dobudan');

//首页跳转登录页面
Route::get('/', 'Admin\LoginController@redirect');
//显示登录页面
Route::get('/login','Admin\LoginController@show_login')->name('login');
//登录操作
Route::post('/login','Admin\LoginController@login');
//错误页面
Route::get('/error','Admin\LoginController@error');
//自动退出登录
Route::group(['middleware'=>'auth:back'],function(){

	//管理后台--退出登录
	Route::get('/logout','Admin\LoginController@logout');
	//管理后台--首页显示
	Route::get('/index/index','Admin\IndexController@index');
	//管理后台--welcome
	Route::get('/welcome','Admin\IndexController@welcome');

	/////////////////////////////////////翻墙///////////////////////////////////////
	Route::group(['middleware'=>'fanqiang'],function(){
		//管理后台--管理员资源
		Route::resource('/manager','Admin\ManagerController');
		//管理后台--权限资源
		Route::resource('/permission','Admin\PermissionController');
		//管理后台--角色资源
		Route::resource('/role','Admin\RoleController');
		//管理后台--权限的分配
		Route::match(['get','post'],'/role/distribute/{role?}','Admin\RoleController@distribute');

		//管理后台--收款银行卡
		Route::resource('/receipt','Admin\ReceiptController');
		//管理后台--收款银行卡状态
		Route::post('/receipt/reset','Admin\ReceiptController@reset');
		
		//管理后台--用户银行卡
		Route::resource('/userbank','Admin\UserBankController');

		//管理后台--银行导入excel
		Route::get('/excel/index','Admin\ExcelController@index');
		//管理后台--导入数据操作
		Route::post('/excel/import','Admin\ExcelController@import');
		//管理后台--订单管理
		Route::resource('/order','Admin\OrderController');

		//管理后台--公告
		Route::resource('/notice','Admin\NoticeController');

		//管理后台--优惠配置
		Route::resource('/sale','Admin\SaleController');
		//管理后台--修改状态
		Route::post('/sale/reset','Admin\SaleController@reset');

		//管理后台--微信商户号
		Route::get('/wechat/index','Admin\WechatController@index');
		//管理后台--微信下单列表查询	??
		Route::get('/wechat/w_order','Admin\WechatController@w_order');
		//管理后台--微信补单列表查询	??
		Route::get('/wechat/budan','Admin\WechatController@budan');

		//管理后台--qr上传
		Route::post('/wechat/upload','Admin\WechatController@upload');
	});
});
