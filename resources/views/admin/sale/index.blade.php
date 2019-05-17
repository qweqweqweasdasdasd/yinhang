@extends('admin/common/master')
@section('title','配置')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 公告优惠 <span class="c-gray en">&gt;</span> 优惠列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">倒序: 大到小
        <!-- <a href="javascript:;" onclick="admin_add('添加优惠','admin-add.html','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加优惠</a> -->
    </span> <span class="r">共有数据：<strong>1</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg mt-20">
		<thead>
			<tr>
				<th scope="col" colspan="9">优惠列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="70">排序</th>
				<th width="150">存款方式</th>
				<th width="90">优惠</th>
				<th>备注</th>
				<th width="130">创建时间</th>
				<th width="100">是否已启用</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
            @foreach($sale as $v)
			<tr class="text-c">
				<td>{{$v->id}}</td>
				<td>{{$v->sort}}</td>
				<td>{{config("code.pay_type.$v->title")}}</td>
				<td>{{$v->yh_per}}</td>
				<td>{{$v->desc}}</td>
				<td>{{$v->created_at}}</td>
				<td class="td-status">{!! reset_receipt_status($v->status) !!}</span></td>
                <td class="td-manage"> <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','/sale/{{$v->id}}/edit','1','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
                    <!-- <a title="删除" href="javascript:;" onclick="admin_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a> -->
                </td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
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

/*优惠-修改状态*/
$('.reset').on('click',function(){
	var status = $(this).attr('data-status');
	var id = $(this).parents('tr').find('td:eq(0)').html();
	
	//ajax
	layer.confirm('确认要修改状态？',function(index){
		$.ajax({
			type: 'post',
			url: '/sale/reset',
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
</script>
@endsection