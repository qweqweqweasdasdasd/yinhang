@extends('admin/common/master')
@section('title','权限列表')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	<input type="hidden" name="ps_id" value="{{$info->ps_id}}">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">权限名称：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" name="ps_name" value="{{$info->ps_name}}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">上级权限：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="ps_pid" size="1">
				@foreach($permission_tree as $vv)
				<option value="{{$vv['ps_id']}}" 
					@if($info->ps_pid == $vv['ps_id']) selected @endif/>
					{{str_repeat('--',$vv['ps_level']).$vv['ps_name']}}
				</option>
				@endforeach
			</select>
			</span> </div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">控制器：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  name="ps_c" value="{{$info->ps_c}}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">方法：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" name="ps_a" value="{{$info->ps_a}}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">路由：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" name="ps_route" value="{{$info->ps_route}}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">备注：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内">{{$info->desc}}</textarea>
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
	$('form').submit(function(evt){
		evt.preventDefault();
		var data = $(this).serialize();
		var ps_id = $('input[type=hidden]').val();

		//ajax
		$.ajax({
			url:'/permission/'+ps_id,
			data:data,
			dataType:'json',
			type:'PATCH',
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