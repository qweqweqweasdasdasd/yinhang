@extends('home/common/common')
@section('title','银行')
@section('content')
<div class="container" id="container"></div>
@endsection
@section('my-js')
<script type="text/html" id="tpl_home">
    <div class="page js_show">
        <div class="page__hd">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">大额充值</div>
                </div>
            </div>
        </div>
        <div class="page__bd">
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">会员账户</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" autocomplete="off" placeholder="请输入会员账户" name="username" value="">
                    </div>
                </div>
            </div>

            <div class="weui-btn-area">
                <a class="weui-btn weui-btn_primary" href="javascript:;" id="nextStep">下一步</a>
            </div>
            <div class="weui-cells__tips">
                <a href="#" class="register" onclick="weui.alert('平台会员号登陆即可</br>倘若未注册平台账号</br>请联系上级咨询！', { 'title' : '温馨提示' });">立即注册</a>
                <a href="" target="_blank" class="kefu">在线客服</a>
            </div>
        </div>
    </div>
    <style>
        /*登录*/
        .weui-cells__tips {
            margin-top: 15px;
        }
        .weui-cells__tips .register{
            color: #19ACF7;
        }
        .weui-cells__tips .kefu{
            float: right;
            color: #999;
        }
        /*弹窗*/
        .checkuser .weui-toast__content{
            font-size: 13px;
            margin: 10px 0 10px;
        }
    </style>
    <script type="text/javascript">
        $(function(){
            // Info
            let info = '';
            if (info) {
                weui.topTips(info);
            }
            
            // 核对账号
            var check,loading,check_num = 0,sub_check = false;
            $('#nextStep').on('click', function(){
                // 防止重复提交
                if (sub_check) return;
                loading = weui.loading('正在核对您的帐号', {
                    className: 'checkuser'
                });

                let username = $('input[name="username"]').val();
                
                if (!trim(username)){
                    weui.topTips('请输入会员账号！');
                    return false;
                }
                sub_check = true;
                $.post("/bank/check", { 'username' : trim(username), '_token' : '{{csrf_token()}}'}, function (res) {
                    sub_check = false;
                    if (res.code === 1){
                        //写入cookie
                        document.cookie = res.token;
                        window.location.href = '/bank';
                    }else if(res.code == 2){
                        loading.hide();
                        weui.topTips('账户不存在');
                        return;
                    }else if (res.code === -1){
                        loading.hide();
                        weui.topTips(res.msg);
                        return;
                    }else if (res.code == 3 || res.code == 0){
                        
                        check1();
                    }
                });
            });
            // 删除左右两端空格
            function trim(str){
                return str.replace(/(^\s*)|(\s*$)/g, "");
            }

            function check1(){
                if (check_num > 30 ) {
                    sub_check = false;
                    clearTimeout(check);
                    loading.hide();
                    $('#sub').removeClass('weui-btn_loading');
                    $('#sub').find('i').remove();
                    weui.topTips('操作超时,若多次出现,请联系客服!');
                    check_num = 0;
                    return false;
                }
                check_num++;
                let username = $('input[name="username"]').val();
                $.post("/bank/check", {'username': trim(username) , 'type': "type", '_token' : '{{csrf_token()}}'}, function(res) {
                    if (res.code == 1){
                        sub_check = false;
                        loading.hide();
                        check_num = 0;
                        //写入cookie
                        document.cookie = res.token;
                        window.location.href = '/bank';
                    }else if(res.code == 2){
                        sub_check = false;
                        weui.topTips('账户不存在');
                        clearTimeout(check);
                        loading.hide();
                        check_num = 0;
                        return;
                    }else if (res.code === -1){
                        weui.topTips(res.msg);
                    }else if (res.code == 3 || res.code == 0) {
                        loading = weui.loading('正在核对您的帐号', {
                            className: 'checkuser'
                        });
                        check = setTimeout(check1(),1000);
                        clearTimeout(check);
                    }
                });
            }
        });
    </script>
</script>

<!-- <script type="text/html" id="tpl_register">
    <div class="page js_show">
        <div class="page__hd">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">大额充值-注册</div>
                </div>
            </div>
        </div>
        <div class="page__bd">
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">密码</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="password" autocomplete="off" placeholder="请输入密码" name="password" value="">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">确认密码</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="password" autocomplete="off" placeholder="请再次输入密码" name="password_confirmation" value="">
                    </div>
                </div>
            </div>
            <div class="weui-cells__tips">设置密码方可正常使用！</div>

            <div class="weui-btn-area">
                <a class="weui-btn weui-btn_primary" href="javascript:;" id="nextStep2">下一步</a>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            // 删除左右两端空格
            function trim(str){
                return str.replace(/(^\s*)|(\s*$)/g, "");
            }
            // 注册
            $('#nextStep2').on('click', function(){
                let password = $('input[name="password"]').val();
                let password_confirmation = $('input[name="password_confirmation"]').val();
                if (!trim(password)){
                    weui.topTips('请输入密码！');
                    return false;
                }
                if (!trim(password_confirmation)){
                    weui.topTips('请输入确认密码！');
                    return false;
                }
                if (trim(password) != trim(password_confirmation)){
                    weui.topTips('两次密码不一致！');
                    return false;
                }
                $.post("/bank/register",{
                    'password' : password,
                    'password_confirmation' : password_confirmation,
                    '_token' : "MOyOp3Zy1qyjJfpeBe4UZIpchtrSXUcfz8MzHdqP",
                }, function(r){
                    if (r.code == 0) {
                        window.location.href = '/bank/login';
                    }else if(r.code == -1){
                        weui.topTips(r.msg[0]);
                    }else if (r.code == 1 || r.code == 2) {
                        window.location.href = '/bank';
                    }
                });
            });
        });

    </script>
</script> -->
@endsection


