@extends('admin/common/master')
@section('title','角色')
@section('my-css')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
@endsection
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray"> <span class="l"><a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加角色','/role/create','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-hover table-bg mt-20">
		<thead>
			<tr>
				<th scope="col" colspan="6">角色管理</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="200">角色名</th>
				<th>管理员列表</th>
				<th width="300">描述</th>
				<th width="70">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($role as $v)
			<tr class="text-c">
			
				<td>{{$v->r_id}}</td>
				<td><span class="label label-default radius">{{$v->r_name}}</span></td>
				<td>
					@foreach($v->managers as $vv)
						{!! role_managers_status($vv->mg_status,$vv->mg_name) !!}
					@endforeach
				</td>
				<td>{{$v->desc}}</td>
				<td class="f-14">
					<a title="分配权限" href="javascript:;" onclick="admin_role_edit('分配权限','/role/distribute/{{$v->r_id}}','1')" style="text-decoration:none"><i class="Hui-iconfont">&#xe60c;</i></a> 
					<a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','/role/{{$v->r_id}}/edit','1')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
					<a title="删除" href="javascript:;" onclick="admin_role_del(this,'{{$v->r_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $role->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript">
/*管理员-角色-添加*/
function admin_role_add(title,url,w,h){
	layer_show(title,url,w,h);
}

/*管理员-角色-编辑*/
function admin_role_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*管理员-角色-删除*/
function admin_role_del(obj,id){
	layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/role/'+id,
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
</script>
@endsection