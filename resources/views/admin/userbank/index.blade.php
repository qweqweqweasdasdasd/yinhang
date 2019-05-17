@extends('admin/common/master')
@section('title','用户银行卡')
@section('my-css')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
@endsection
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 银行卡系统 <span class="c-gray en">&gt;</span> 用户银行卡列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c"> 
        <form>
            <input type="text" class="input-text" style="width:250px" placeholder="银行卡"  name="bank_code" value="{{$data['bank_code']}}">
            <input type="text" class="input-text" style="width:250px" placeholder="用户名"  name="u_id" value="{{$data['username']}}">
            <button type="submit" class="btn btn-success" ><i class="Hui-iconfont">&#xe665;</i> 查询</button>
        </form>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"></span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg mt-20">
		<thead>
			<tr>
				<th scope="col" colspan="10">用户银行卡列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="100">用户名</th>
				<th width="180">卡号</th>
				<th width="100">银行</th>
				<th>银行地址</th>
                <th width="100">是否验证</th>
                <th width="80">验证金额</th>
                <th width="130">创建时间</th>
                <th width="130">更新时间</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
            @foreach($userbank as $v)
			<tr class="text-c">
				<td>{{$v->id}}</td>
				<td>{{$v->user->username}}</td>
				<td>{{$v->bank_code}}</td>
                <td>{{$v->bank_name}}</td>
                <td>{{$v->bank_addr}}</td>
				<td class="td-status">{!! show_manager_status($v->cert_status,'未验证','验证','补单') !!}</td>
                <td>{{$v->cert_monney}}</td>
				<td>{{$v->created_at}}</td>
				<td>{{$v->updated_at}}</td>
				<td class="td-manage"> <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','/userbank/{{$v->id}}/edit','1','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'{{$v->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
			@endforeach
		</tbody>
    </table>
    {{ $userbank->links() }}
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
			type: 'DELETE',
			url: '/userbank/'+id,
            dataType: 'json',
            headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
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

/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

</script>
@endsection