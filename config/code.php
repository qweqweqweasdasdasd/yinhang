<?php

return [
    'response' => [
    	'success'=>'1',
    	'error'=>'0'
    ],
    'token_life_time_out'=>1,	//token失效期
    'order_unique_expiry'=>22880,    //导入excel避免重复的唯一键失效时间 2880秒 => 2天
    'pay_type'=>[
        '1'=>'银行存款',
    ],
    'sign_key'=>'123456'
];
