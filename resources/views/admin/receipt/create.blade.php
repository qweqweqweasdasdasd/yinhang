@extends('admin/common/master')
@section('title','新增收款卡')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">卡号：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="" placeholder="输入卡号"  name="bank_code">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">开户姓名：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  value="" placeholder="输入开户姓名"  name="account_name">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">开户银行：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"   placeholder="输入开户银行"  name="bank_name">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">开户地址：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"   placeholder="输入开户地址"  name="bank_addr">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">是否启用：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="start_use_status" type="radio" id="sex-1" checked value="1">
				<label for="sex-1">启用</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="sex-2" name="start_use_status" value="2">
				<label for="sex-2">暂停</label>
			</div>
		</div>
	</div>
	<!-- <div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">备注：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)"></textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div> -->
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
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
			url:'/receipt',
			data:data,
			dataType:'json',
			type:'POST',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 1){
					//parent.self.location = parent.self.location;
					layer.alert('创建成功!',function(){
						parent.self.location = parent.self.location;
					})
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