@extends('admin/common/master')
@section('title','订单管理')
@section('content')
<article class="page-container">
<div class="panel panel-default">
	<div class="panel-header">补单之后会自动把用户绑定的转账银行卡,重新创建一个转账银行卡信息</div>
	<div class="panel-body">
			<form class="form form-horizontal" id="form-admin-add">
			<input type="hidden" value="{{$id}}" name="o_id">
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">会员账号：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" name="username">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">当笔转账银行卡号：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" name="bank_code" value="{{$order->bank_account}}">
				</div>
			</div>
			<div class="row cl">
				<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
					<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;确认补单&nbsp;&nbsp;">
				</div>
			</div>
			</form>
	</div>
</div>
</article>
@endsection
@section('my-js')
<script type="text/javascript">
$('#form-admin-add').submit(function(evt){
		evt.preventDefault();
		var data = $(this).serialize();
		var id = $('input[type=hidden]').val();

		//ajax
		$.ajax({
			url:'/order/'+id,
			data:data,
			dataType:'json',
			type:'PATCH',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 1){
					layer.alert('请求接口成功!',{title:'提示'},function(){
						parent.self.location = parent.self.location;
					})
				}else if(msg.code == -1){
					layer.alert(msg.msg,{title:'提示'});
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