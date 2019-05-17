@extends('admin/common/master')
@section('title','通知')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-edit">
	<!-- <div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">支付方式：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="adminRole" size="1">
				<option value="0">超级管理员</option>
				<option value="1">总编</option>
				<option value="2">栏目主辑</option>
				<option value="3">栏目编辑</option>
			</select>
			</span> </div>
	</div> -->
	<div class="row cl">
        <label class="form-label col-xs-4 col-sm-2">公告：</label>
        <input type="hidden" name="n_id" value="{{$notice->n_id}}">
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="content" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" >{{$notice->content}}</textarea>
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
<script>
    $('#form-edit').submit(function(evt){
        evt.preventDefault();
        var data = $(this).serialize();
        var id = $('input[type=hidden]').val();
        //ajax
        $.ajax({
            url:'/notice/'+id,
            data:data,
            dataType:'json',
            type:'PATCH',
            headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
            },
            success:function(msg){
                if(msg.code == 1){
                    self.location.href  = self.location.href ;
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
