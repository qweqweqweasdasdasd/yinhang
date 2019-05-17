@extends('admin/common/master')
@section('title','角色')
@section('content')
<article class="page-container">
	<form  class="form form-horizontal" id="form-admin-role-add">
		<input type="hidden" name="r_id" value="{{$info->r_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$info->r_name}}"  name="r_name" readonly>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">权限列表：</label>
			<div class="formControls col-xs-8 col-sm-9">
				@foreach($permission_i as $v)
				<dl class="permission-list">
					<dt>
						<label>
							<input type="checkbox" value="{{$v->ps_id}}" name="quan[]" id="user-Character-0"
							@if(in_array($v->ps_id,$info_ps_ids)) checked @endif>
							{{$v->ps_name}}</label>
					</dt>
					<dd>
						@foreach($permission_ii as $vv)
						@if( $vv->ps_pid == $v->ps_id )
						<dl class="cl permission-list2">
							<dt>
								<label class="">
									<input type="checkbox" value="{{$vv->ps_id}}" name="quan[]" id="user-Character-0-0"
									@if(in_array($vv->ps_id,$info_ps_ids)) checked @endif>
									{{$vv->ps_name}}</label>
							</dt>
							<dd>
								@foreach($permission_iii as $vvv)
								@if($vvv->ps_pid == $vv->ps_id)
								<label class="">
									<input type="checkbox" value="{{$vvv->ps_id}}" name="quan[]" id="user-Character-0-0-0"
									@if(in_array($vvv->ps_id,$info_ps_ids)) checked @endif>
									{{$vvv->ps_name}}</label>
								@endif
								@endforeach
							</dd>
						</dl>
						@endif
						@endforeach
					</dd>
				</dl>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button type="submit" class="btn btn-success radius" ><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>
@endsection
@section('my-js')
<script type="text/javascript">
$('#form-admin-role-add').submit(function(evt){
	evt.preventDefault();
	var data = $(this).serialize();
	var r_id = $('input[type=hidden]').val();

	//判断是否勾选
	if($('input[type=checkbox]:checked').length < 1){
		layer.alert('请选择被分配的权限',{icon:5});
		return false;
	}
	//ajax
	$.ajax({
		url:'/role/distribute/'+r_id,
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

$(function(){
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		var l =$(this).parent().parent().find("input:checked").length;
		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			if(l==0){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
			}
			if(l2==0){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});
});
</script>
@endsection