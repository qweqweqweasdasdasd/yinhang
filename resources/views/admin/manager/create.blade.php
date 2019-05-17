@extends('admin/common/master')
@section('title','创建管理员')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">管理名称：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  placeholder="输入管理员名称"  name="mg_name">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">初始密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text"  placeholder="初始密码"  name="password">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">确认密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text"  placeholder="确认密码"  name="password_confirmation">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">状态：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="mg_status" type="radio" id="sex-1" checked value="1">
				<label for="sex-1">正常</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="sex-2" name="mg_status" value="0">
				<label for="sex-2">停用</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">角色：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="r_id" size="1">
				@foreach($rname_rid as $k=>$v)
				<option value="{{$k}}">{{$v}}</option>
				@endforeach
			</select>
			</span> </div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">备注：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)"></textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
@endsection
@section('my-js')
<script type="text/javascript">
	$('#form-admin-add').submit(function(evt){
		evt.preventDefault();
		var data = $(this).serialize();
		//ajax
		$.ajax({
			url:'/manager',
			data:data,
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 1){
					//parent.window.location.href = '/role';
					parent.self.location = parent.self.location;
				}else if(msg.code == 0){
					layer.alert(msg.error,{title:'提示'});
				}
			},
			error:function(jqXHR, textStatus, errorThrown){
				var msg = '';
				$.each(JSON.parse(jqXHR.responseText).errors,function(i,item){
					msg += item;
				});
				if(msg != ''){
					layer.alert(msg,{title:'提示'});
				}
			}
		})
	});
</script>
@endsection
