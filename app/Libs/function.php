<?php 

//角色列表显示管理员 0 禁用,1 正常
function role_managers_status($mg_status,$mg_name)
{
	if($mg_status == 0){
		return '<span class="label label-danger radius">'.$mg_name.'</span>';
	}
	if($mg_status == 1){
		return '<span class="label label-success radius">'.$mg_name.'</span>';
	}
}
//管理员状态 0 禁用,1 正常
//银行卡状态 0 未验证 1 验证
function show_manager_status($mg_status,$val0,$val1,$val2)
{
	if($mg_status == 0){
		return '<span class="label label-danger radius mg_status" data-status="1">'.$val0.'</span>';
	}
	if($mg_status == 1){
		return '<span class="label label-success radius mg_status" data-status="0">'.$val1.'</span>';
    }
    if($mg_status == 2){
		return '<span class="label label-warning radius mg_status" data-status="0">'.$val2.'</span>';
    }
}

//权限级别显示 0 顶级权限 1 一级权限 2 二级权限
function show_permission_level($ps_level)
{
    if($ps_level == 0){
        return '<span class="label label-default radius">顶级权限</span>';
    }
    if($ps_level == 1){
        return '<span class="label label-success radius">一级权限</span>';
    }
    if($ps_level == 2){
        return '<span class="label label-secondary radius">二级权限</span>';
    }
}

//订单状态   1 生成订单 2会员账号银行卡对应异常  3支付成功 4请求第四方接口失败 5列队失败 6进入队列
function show_order_status($code)
{
    if($code == 1){
        return '<span class="label label-default radius">生成订单</span>';
    }
    if($code == 2){
        return '<span class="label label-warning radius">会员账号银行卡对应异常</span>';
    }
    if($code == 3){
        return '<span class="label label-success radius">支付成功</span>';
    }
    if($code == 4){
        return '<span class="label label-danger radius">请求第四方接口失败</span>';
    }
    if($code == 5){
        return '<span class="label label-danger radius">列队失败</span>';
    }
    if($code == 6){
        return '<span class="label label-secondary radius">进入队列</span>';
    }
}

//微信订单状态   1 生成订单  2,会员账号无效 3,服务器内部原因 4,支付到账 5,补单成功
function show_wx_order_status($code)
{
    if($code == 1){
        return '<span class="label label-default radius">生成订单</span>';
    }
    if($code == 2){
        return '<span class="label label-warning radius">会员账号无效</span>';
    }
    if($code == 3){
        return '<span class="label label-danger radius">服务器内部原因</span>';
    }
    if($code == 4){
        return '<span class="label label-success radius">支付到账</span>';
    }
    if($code == 5){
        return '<span class="label label-primary  radius">补单成功</span>';
    }
 
}

//收款银行卡状态修改    1 开启 2停用
function reset_receipt_status($code)
{
    if($code == 1){
        return '<input class="btn btn-primary size-S radius reset" type="button" value="开启" data-status="2">';
    }
    if($code == 2){
        return '<input class="btn btn-default size-S radius reset" type="button" value="停用" data-status="1">';
    }
}

//递归方式获取上下级权限信息
function generateTree($data){
    $items = array();
    foreach($data as $v){
        $items[$v['ps_id']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){
        if(isset($items[$item['ps_pid']])){
            $items[$item['ps_pid']]['son'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return getTreeData($tree);
}
function getTreeData($tree,$level=0){
    static $arr = array();
    foreach($tree as $t){
        $tmp = $t;
        unset($tmp['son']);
        //$tmp['level'] = $level;
        $arr[] = $tmp;
        if(isset($t['son'])){
            getTreeData($t['son'],$level+1);
        }
    }
    return $arr;
}
/**
 * 获取当前控制器名
 */
function getCurrentControllerName()
{
    return getCurrentAction()['controller'];
}

/**
 * 获取当前方法名
 */
function getCurrentMethodName()
{
    return getCurrentAction()['method'];
}


/**
 * 获取当前控制器与操作方法的通用函数
 */
function getCurrentAction()
{
    $action = \Route::current()->getActionName();
    //dd($action);exit;
    //dd($action);
    //return $action;
    list($class, $method) = explode('@', $action);
    //$classes = explode(DIRECTORY_SEPARATOR,$class);
    $class = str_replace('Controller','',substr(strrchr($class,'\\'),1));

    return ['controller' => $class, 'method' => $method];
}

