@extends('admin/common/master')
@section('title','用户银行')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
        <input type="hidden" value="{{$info->id}}">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">银行卡号：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{$info->bank_code}}"  name="bank_code">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">银行名：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  name="bank_name" value="{{$info->bank_name}}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">银行地址：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  name="bank_addr" value="{{$info->bank_addr}}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">是否验证：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  name="cert_status" value="{{$info->cert_status}}" readonly="readonly" >
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">验证金额：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{$info->cert_monney}}"  name="cert_monney" readonly="readonly" >
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
@endsection
@section('my-js')
<script>
    $('#form-admin-add').submit(function(evt){
        evt.preventDefault();
        var data = $(this).serialize();
        var id = $('input[type="hidden"]').val();
        //ajax
        $.ajax({
            url:'/userbank/'+id,
            data:data,
            type:'PATCH',
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
            },
            success:function(msg){
				if(msg.code == 1){
					layer.alert('修改成功!',{title:'提示'},function(){
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