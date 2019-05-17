@extends('admin/common/master')
@section('title','管理员列表')
@section('my-css')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
@endsection
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
		<form>
			<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" name="mg_name" value="{{$dataWhere['mg_name']}}">
			<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜管理员</button>
		</form>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="admin_add('添加管理员','/manager/create','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg mt-20">
		<thead>
			<tr>
				<th scope="col" colspan="9">管理员列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="150">管理员名称</th>
				<th width="90">登录次数</th>
				<th width="150">ip</th>
				<th width="150">角色</th>
				<th>备注</th>
				<th width="130">最后登录时间</th>
				<th width="100">是否已启用</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $v)
			<tr class="text-c">
				<td>{{$v->mg_id}}</td>
				<td>{!! role_managers_status($v->mg_status,$v->mg_name) !!}</td>
				<td>{{$v->mg_login_count}}</td>
				<td>{{$v->mg_ip}}</td>
				<td><span class="label label-default radius">{{$v->role->r_name}}</span></td>
				<td>{{$v->desc}}</td>
				<td>{{$v->mg_last_login_time}}</td>
				<td class="td-status">{!! show_manager_status($v->mg_status,'停用','正常','') !!}</td>
				<td class="td-manage"><a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','manager/{{$v->mg_id}}/edit','1','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'{{$v->mg_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
{{ $data->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript">
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/manager/'+id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
</script>
@endsection
