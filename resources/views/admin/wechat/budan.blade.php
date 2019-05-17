@extends('admin/common/master')
@section('title','微信下单列表')
@section('my-css')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
@endsection
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 微信商户 <span class="c-gray en">&gt;</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
		<form>
			<input type="text" class="input-text" style="width:250px" placeholder="输入订单号和会员账号" id="" name="trade_no" value="{{$whereData['trade_no']}}">
			<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 查询</button>
		</form>	
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">最低1元平台需要调整</span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg mt-20">
		<thead>
			<tr>
				<th scope="col" colspan="9">订单列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="100">用户名称</th>
				<th width="200">订单号</th>
				<th width="100">金额</th>
                
				<th>详情</th>
				<th width="150">补单时间</th>
                <th width="150">状态</th>
			</tr>
		</thead>
		<tbody>
            @foreach($budan as $v)
			<tr class="text-c">
				<td>{{$v->b_id}}</td>
				<td>{{$v->input_name}}</td>
				<td>{{$v->w_trade_no}}</td>
				<td>{{$v->money}}</td>
                
				<td>{{$v->desc}}</td>
                <td>{{$v->created_at}}</td>
				<td class="td-status">{!!show_wx_order_status($v->status) !!}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $budan->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
@endsection