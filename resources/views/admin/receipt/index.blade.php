@extends('admin/common/master')
@section('title','收款银行卡')
@section('my-css')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
@endsection
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 银行卡系统 <span class="c-gray en">&gt;</span> 收款列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="admin_add('添加收款卡','/receipt/create','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加收款卡</a></span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="9">收款列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="180">卡号</th>
				<th width="200">开户姓名</th>
				<th width="150">开户银行</th>
				<th>开户地址</th>
				<th width="100">是否启用</th>
				<th width="130">添加时间</th>
				<th width="130">更新时间</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($list as $v)
			<tr class="text-c">
				<td>{{$v->b_id}}</td>
				<td>{{$v->bank_code}}</td>
				<td>{{$v->account_name}}</td>
				<td>{{$v->bank_name}}</td>
				<td>{{$v->bank_addr}}</td>
				<td class="td-status">{!! reset_receipt_status($v->start_use_status) !!}</td>
				<td>{{$v->created_at}}</td>
				<td>{{$v->updated_at}}</td>
				<td class="td-manage"> <a title="编辑" href="javascript:;" onclick="admin_edit('收款卡编辑','/receipt/{{$v->b_id}}/edit','1','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'{{$v->b_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $list->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript">
/*收款卡-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*收款卡-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/receipt/'+id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(data){
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
/*收款卡-修改状态*/
$('.reset').on('click',function(){
	var status = $(this).attr('data-status');
	var id = $(this).parents('tr').find('td:eq(0)').html();
	
	//ajax
	layer.confirm('确认要修改状态？',function(index){
		$.ajax({
			type: 'post',
			url: '/receipt/reset',
			dataType: 'json',
			data:{id:id,status:status},
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(data){
				if(data.code == 1){
					self.location = self.location;
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
})
/*收款卡-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
</script>
@endsection