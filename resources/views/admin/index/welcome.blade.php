@extends('admin/common/master')
@section('title','welcome')
@section('content')
<div class="page-container">
	<p>登录次数：{{$manager->mg_login_count}} </p>
	<p>上次登录IP：{{$manager->mg_ip}}  上次登录时间：{{$manager->mg_last_login_time}}</p>
</div>
@endsection