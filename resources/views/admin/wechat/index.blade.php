@extends('admin/common/master')
@section('title','qr')
@section('my-css')
<link rel="stylesheet" href="/admin/layui/css/layui.css" media="all">
@endsection
@section('content')
<article class="page-container">
    <div class="panel panel-default">
        <div class="panel-header">微信商户QR</div>
        <div class="panel-body">
            <div class="row cl">
                <div class="formControls col-xs-8 col-sm-9">
                    <img id="pathinfo" src="{{$qr->qr_path}}" alt="no qr" style="width: 300px;">
                </div>
            </div>
        </div>
    </div>
    <div class="mt-20">
        <button type="button" class="layui-btn" id="test1">
            <i class="layui-icon">&#xe67c;</i>上传商户微信二维码
        </button>
    </div>
</article>
@endsection
@section('my-js')
<script src="/admin/layui/layui.js"></script>
<script>
    layui.use('upload',function(){
        var upload = layui.upload;
        var uploadInst = upload.render({
            elem: '#test1' //绑定元素
            ,url: '/wechat/upload' //上传接口
            ,method: 'post'
            ,type : 'images'
            ,exts: 'jpg|png|gif'
            ,headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
            }
            ,done: function(res){
                if(res.code == 1){
                    //$('#pathinfo').attr('src',res.path);
                    self.location.href = self.location.href;    //刷新
                }
                if(res.code == 0){
                    layer.alert(res.msg);
                }
            //上传完毕回调
            }
            ,error: function(){
            //请求异常回调
            }
        });
    });
</script>
@endsection