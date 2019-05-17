@extends('admin/common/master')
@section('title','优惠配置')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
        <input type="hidden" value="{{$sale->id}}" name="id">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">排序：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="number" class="input-text"  name="sort" style="width:200px" value="{{$sale->sort}}">
		</div>
	</div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2">存款方式：</label>
        <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:200px;">
            <select class="select" name="title" size="1">
                <option value="1">银行存款</option>
                <!-- <option value="2">栏目主辑</option>
                <option value="3">栏目编辑</option> -->
            </select>
            </span> </div>
    </div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">优惠：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  name="yh_per" value="{{$sale->yh_per}}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">状态：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="status" type="radio" id="sex-1"  value="1" @if($sale->status == 1) checked @endif>
				<label for="sex-1">开启</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="sex-2" name="status"  value="2" @if($sale->status == 2) checked @endif>
				<label for="sex-2">关闭</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">备注：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)">{{$sale->desc}}</textarea>
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
    $('#form-admin-add').submit(function(evt){
        evt.preventDefault();
        var data = $(this).serialize();
        var id = $('input[type=hidden]').val();

        //ajax
        $.ajax({
            url:'/sale/'+id,
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