@extends('admin/common/master')
@section('title','微信下单列表')
@section('my-css')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
@endsection
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 微信商户 <span class="c-gray en">&gt;</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c"> 
		<form >
			日期范围：
			<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:200px;" name="datemin" value="{{$whereData['datemin']}}">
			-
			<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d %H-$i-$s' })" id="datemax" class="input-text Wdate" style="width:200px;" name="datemax" value="{{$whereData['datemax']}}">
			<input type="text" class="input-text" style="width:300px" placeholder="输入订单号或者会员账号"  name="trade_no" value="{{$whereData['trade_no']}}">
			<button type="submit" class="btn btn-success"  name=""><i class="Hui-iconfont">&#xe665;</i> 查询</button>
		</form>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">最低1元平台需要调整</span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg ">
		<thead>
			<tr>
				<th scope="col" colspan="9">订单列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="100">用户名称</th>
				<th width="210">订单号</th>
				<th width="100">金额</th>
                <th width="100">支付类型</th>
				<th>详情</th>
				<th width="150">订单时间</th>
                <th width="150">状态</th>
			</tr>
		</thead>
		<tbody>
            @foreach($worder as $v)
			<tr class="text-c">
				<td>{{$v->w_id}}</td>
				<td>{{$v->username}}</td>
				<td>{{$v->trade_no}}</td>
				<td>{{$v->money}}</td>
                <td>{{$v->pay_type}}</td>
				<td>{{$v->desc}}</td>
                <td>{{$v->trade_time}}</td>
				<td class="td-status">{!! show_wx_order_status($v->status) !!}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $worder->appends([datemin=>$whereData['datemin'], datemax=>$whereData['datemax'], trade_no=>$whereData['trade_no']])->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
@endsection