@extends('admin/common/master')
@section('title','登录')
@section('my-css')
<link href="/admin/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal" action="index.html" method="post">
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
          <input name="mg_name" type="text" placeholder="账户" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe63f;</i></label>
        <div class="formControls col-xs-8">
          <input name="password" type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input class="input-text size-L" type="text" placeholder="验证码" name="code" style="width:175px;">
          <img src="{{Captcha::src()}}" onclick="this.src= '{{Captcha::src()}}'+'?'+ Math.random();"> </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@section('my-js')
<script>
	$('form').submit(function(evt){
		evt.preventDefault();
		var data = $(this).serialize();
		//ajax
		$.ajax({
			url:'/login',
			data:data,
			type:'post',
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 0){
					layer.alert(msg.error);
				}
				if(msg.code == 1){
					window.location.href = '/index/index'; 
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