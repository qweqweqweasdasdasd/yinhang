@extends('admin/common/master')
@section('title','权限')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="admin_permission_add('添加权限节点','/permission/create','','310')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限节点</a></span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="7">权限节点</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="200" >权限名称</th>
				<th width="150" >权限等级</th>
				<th>路由</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($permission_tree as $vv)
			<tr class="text-c">
				<td>{{$vv['ps_id']}}</td>
				<td class="text-l">&nbsp;&nbsp;&nbsp;&nbsp;{{str_repeat('--',$vv['ps_level']).$vv['ps_name']}}</td>
				<td>{!! show_permission_level($vv['ps_level']) !!}</td>
				<td>{{$vv['ps_route']}}</td>
				@if($vv['ps_pid'] == 0)
				<td></td>
				@else
				<td><a title="编辑" href="javascript:;" onclick="admin_permission_edit('权限编辑','/permission/{{$vv['ps_id']}}/edit','1','','310')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_permission_del(this,'{{$vv['ps_id']}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
/*管理员-权限-添加*/
function admin_permission_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-权限-编辑*/
function admin_permission_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*管理员-权限-删除*/
function admin_permission_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/permission/'+id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
			},
			success: function(data){
				if(data.code == 0){
					layer.alert(data.error,{title:'提示'});
				}
				if(data.code == 1){
					$(obj).parents("tr").remove();
					layer.msg('已删除!',{icon:1,time:1000});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script>
@endsection
