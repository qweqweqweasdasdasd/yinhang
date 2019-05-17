@extends('admin/common/master')
@section('title','角色创建')
@section('content')
<article class="page-container">
	<form  class="form form-horizontal" id="form-admin-role-add">
		<input type="hidden" name="r_id" value="{{$info->r_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" name="r_name" value="{{$info->r_name}}">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="desc" cols="" rows="" class="textarea" >{{$info->desc}}</textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
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
		var r_id = $('input[name=r_id]').val();

		//ajax
		$.ajax({
			url:'/role/'+r_id,
			data:data,
			type:'PATCH',
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
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
