@extends('admin/common/master')
@section('title','银行导入数据')
@section('my-css')
<link rel="stylesheet" href="/admin/layui/css/layui.css" media="all">
@endsection
@section('content')
<article class="page-container">
    <div class="panel panel-default">
        <div class="panel-header">银行存款数据导入后自动上分<span style="color:#F00"> (严格按照导入的文件类型进行操作,不然后果自负!!) </span></div>
        <div class="panel-body">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-1">支持类型：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        
                        <label for="bank-1">建设企业银行(A058171TB_ND65587100000526048100.xls)</label>
                    </div>
                    <div class="radio-box">
                
                        <label for="bank-2">工商企业银行(historydetail2552.xlsx)</label>
                    </div>
                    <div class="radio-box">
                        <label for="bank-3">招商企业银行(537900768010505-20190104-20190104.xls)</label>
                    </div>
                    <!-- <div class="radio-box">
                        <label for="bank-4">兴业个人银行(TransDetail1546652970656.xls)</label>
                    </div> -->
                </div>
            </div>    
        </div>
    </div>
    <div class="mt-20">
        <button type="button" class="layui-btn" id="test1">
            <i class="layui-icon">&#xe67c;</i>上传银行数据
        </button>
    </div>
</article>
@endsection
@section('my-js')
<script src="/admin/layui/layui.js"></script>
<script>
    layui.use('upload', function(){
    var upload = layui.upload;
    
    //执行实例
    var uploadInst = upload.render({
        elem: '#test1' //绑定元素
        ,url: '/excel/import' //上传接口
        ,accept: 'file'
        ,method: 'post'
        ,headers:{
            'X-CSRF-TOKEN':"{{csrf_token()}}"
        }
        ,done: function(res){
            if(res.code == 1){
                layer.alert('导入完毕');
            }
            if(res.code == 0){
                layer.alert('导入文件类型是不是不对!');
            }
            console.log(res);
        }
        ,error: function(){
            //请求异常回调
            
        }
    });
    });
</script>
@endsection
