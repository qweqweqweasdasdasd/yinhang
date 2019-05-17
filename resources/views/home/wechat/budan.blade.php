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
                    <div class="weui-cell__bd">自动补单</div>
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
                        <input class="weui-input" type="text" autocomplete="off" placeholder="请输入会员账户" name="input_name">
                    </div>
				</div>
				<div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">充值金额</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" autocomplete="off" placeholder="请输入充值金额" name="money">
                    </div>
				</div>
				<div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">商户单号</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" autocomplete="off" placeholder="请输入商户单号" name="w_trade_no">
                    </div>
                </div>
            </div>

            <div class="weui-btn-area">
                <a class="weui-btn weui-btn_primary" href="javascript:;" id="nextStep">确认补单</a>
            </div>
            <div class="weui-cells__tips">
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
			//点击事件
			$('#nextStep').on('click',function(){
				var input_name = $('input[name="input_name"]').val();
				var money = $('input[name="money"]').val();
				var w_trade_no = $('input[name="w_trade_no"]').val();
				// if (!trim(input_name)){
                //     weui.topTips('请输入会员账号！');
                //     return false;
				// }
				// if (!trim(money)){
                //     weui.topTips('请输入金额！');
                //     return false;
				// }
				// if (!trim(w_trade_no)){
                //     weui.topTips('请输入订单号！');
                //     return false;
                // }
				var data = {input_name:input_name,money:money,w_trade_no:w_trade_no};

				//ajax
				$.ajax({
					url:'/pay/budan',
					data:data,
					type:'post',
					dataType:'json',
					headers:{
						'X-CSRF-TOKEN':"{{csrf_token()}}"
					},
					success:function(msg){
						if(msg.code == 0){
							weui.topTips(msg.msg,{title:'提示'});
						}
						if(msg.code == 1){
							weui.topTips(msg.msg,{title:'提示'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						var msg = '';
						$.each(JSON.parse(jqXHR.responseText).errors,function(i,item){
							msg += item;
						});
						if(msg != ''){
							weui.topTips(msg,{title:'提示'});
						}
					}
				})
			});

			// 删除左右两端空格
            function trim(str){
                return str.replace(/(^\s*)|(\s*$)/g, "");
            }
        });
    </script>
</script>
@endsection


