@extends('admin/common/master')
@section('title','订单管理')
@section('my-css')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
@endsection
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 银行卡系统 <span class="c-gray en">&gt;</span> 订单管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
        <form >
            <input type="text" class="input-text" style="width:200px" placeholder="输入银行卡"  name="bank_account" value="{{$data['bank_account']}}">
            <input type="text" class="input-text" style="width:200px" placeholder="输入订单号"  name="order_no" value="{{$data['order_no']}}">
            <input type="text" class="input-text" style="width:200px" placeholder="输入会员账号"  name="username" value="{{$data['username']}}">
            <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </form>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-10"> <span class="l" >会员账号为null:会员账号与银行卡账号没有找到合适的对应,无法到账,人工修改银行卡账号,然后补单自动到账</span> <span class="r">共有数据：<strong>{{$count}}</strong> 条,&nbsp;&nbsp;金额: <strong>{{$total}}</strong> 元 </span> </div>
	<table class="table table-border table-bordered table-bg mt-10">
		<thead>
			<tr>
				<th scope="col" colspan="10">订单列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="150">银行卡号</th>
				<th width="200">订单号</th>
				<th width="80">订单金额</th>
				<th width="80">订单状态</th>
				<th width="80">会员账号</th>
				<!-- <th>备注</th> -->
				<th>记录</th>
				<th width="150">创建时间</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
            @foreach($orders as $v)
			<tr class="text-c">
				<td>{{$v->o_id}}</td>
				<td>{{$v->bank_account}}</td>
				<td>{{$v->order_no}}</td>
				<td>{{$v->money}}</td>
				<td>{!! show_order_status($v->status) !!}</td>
				<td>{{$v->username}}</td>
				<!-- <td>{{$v->desc}}</td> -->
				<td>{{$v->bio}}</td>
				<td>{{$v->created_at}}</td>
				<td class="td-manage">
					@if($v->status == 2 || $v->status == 4)
					<a title="补单" class="btn btn-success radius size-S" onclick="admin_edit('补单','/order/{{$v->o_id}}/edit','1','800','500')" >补单</a>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $orders->links() }}

</div>
@endsection
@section('my-js')
<script type="text/javascript">
/*管理员-删除*/
function del(obj,id){
	layer.confirm('确认要删除？',function(index){
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
</script>
@endsection