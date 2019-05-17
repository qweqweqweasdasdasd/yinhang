@extends('home/common/common')
@section('title','银行卡系统')
@section('extend')
<link rel="stylesheet" href="/home/css/small_logo_sprite.css">
<script src="/home/js/index.js"></script>
<script src="/home/js/clipboard.min.js"></script>
<script src="/home/js/vue.min.js"></script>
@endsection
@section('content')
<div class="container" id="container" style="margin-top: 50px;"
></div>
@endsection
@section('my-js')
<script type="text/html" id="tpl_home">
    <div class="page js_show">
        <div class="page__hd">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">大额充值<a href="/bank/logout" id="logout" style="font-size: 12px; color: #999;margin-left: 5px;">(登出)</a></div>
                </div>
            </div>
        </div>
        <div class="page__bd">
            <div class="weui-cells">
                <div class="weui-cell weui-cell_access js_item" data-id="bank_list">
                    <div class="weui-cell__bd">付款银行卡</div>
                    <div class="weui-cell__ft">
                                                    <div class='ui-banklogo ui-banklogo-s-'></div>
                                                    添加银行卡
                            <!-- 中国工商银行(尾号4027) -->
                                            </div>
                </div>
                <div class="weui-cell js_item">
                    <div class="weui-cell__bd">充值到</div>
                    <div class="weui-cell__ft">
                        <img src="/home/img/user.png" style="width: 20px;height: 20px;vertical-align: middle;margin-right: 10px;">{{$user->username}}
                    </div>
                </div>
            </div>
            <!-- 判断用户是否有绑定了银行卡 -->
            
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">提示，存款前请先绑定银行卡信息，存款成功后无需提交订单系统自动添加额度。</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">存款成功后系统自动添加1%优惠到账号上面。</div>
                </div>
                                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">请跟进下面显示的银行信息进行转账存款，以免造成无法到账。</div>
                </div>
                                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">转账之前请务必确认是否是最新银行卡</div>
                </div>
                                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips">打开银行APP或网银向以下账户转账完成充值</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips2">务必使用已绑定的银行卡</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">其他通知： 转账额度大于10元 ! 账户在下方</div>
                </div>
                
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_title">大额充值专用账户</div>
                </div>
                <div class="weui-cell info">
                    <div class="weui-cell__hd">开户姓名</div>
                    <div class="weui-cell__bd">{{$bank->account_name}}</div>
                    <div class="weui-cell__ft copy" data-clipboard-text="{{$bank->account_name}}" onclick="">复制</div>
                </div>
                <div class="weui-cell info">
                    <div class="weui-cell__hd">银行账号</div>

                    <div class="weui-cell__bd" id="bank_code">{{$bank->bank_code}}</div>
                    <div class="weui-cell__ft copy" data-clipboard-text="{{$bank->bank_code}}" onclick="">复制</div>
                    
                </div>
                <div class="weui-cell info">
                    <div class="weui-cell__hd">开户银行</div>
                    <div class="weui-cell__bd">{{$bank->bank_name}}</div>
                    <div class="weui-cell__ft copy"  data-clipboard-text="{{$bank->bank_name}}" onclick="">复制</div>
                </div>
                <div class="weui-cell info">
                    <div class="weui-cell__hd">开户地址</div>
                    <div class="weui-cell__bd">{{$bank->bank_addr}}</div>
                    <div class="weui-cell__ft copy"  data-clipboard-text="{{$bank->bank_addr}}" onclick="">复制</div>
                </div>
                </div>
                
            </div>
           
            <!-- 判断用户是否有绑定了银行卡 -->
        <div class="page__ft">
            <a href="javascript:;" id="Process" >大额充值到账流程</a>
        </div>

        
        <div class="Process" style="display: none">
            <div class="weui-mask weui-animate-fade-in"></div>
            <div class="weui-dialog weui-animate-fade-in">
                <div class="weui-dialog__hd">
                    <strong class="weui-dialog__title">大额充值到账流程</strong>
                </div>

                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><img src="/home/img/cny.png" alt=""></div>
                        <div class="weui-cell__bd">第一步</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">通过银行APP或网银转账至大额充值专用账户</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><img src="/home/img/bank.png" alt=""></div>
                        <div class="weui-cell__bd">第二步</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">核实转账，等待银行处理</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><img src="/home/img/success.png" alt=""></div>
                        <div class="weui-cell__bd">第三步</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            充值成功
                            <span>完成银行转账后，一般 3 分钟内充值到账，具体以银行收到款项时间为准</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){
            $('.js_item').on('click', function(){
                let id = $(this).data('id');
                window.pageManager.go(id);
            });
            // Info
            let info = '';
            if (info) {
                weui.topTips(info);
            }
            // 大额充值到账流程
            $('#Process,.Process').on('click', function(){
                $('.Process').toggle();
            });

            let clp = new ClipboardJS('.copy');
            clp.on('success', function(e) {
                weui.toast('复制成功', 1000);
            });
            clp.on('error', function(e) {
                console.log(e);
            });
            let bank_code = $('#bank_code').html();

            bank_code = bank_code.replace(/\s/g, '');
            setInterval(function(){
                var currenttoken = document.cookie.split(';')[0];
                $.ajax({
                    url:'/bank/bank_check',
                    data:'',
                    dataType:'json',
                    type:'post',
                    headers:{
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                    },
                    success:function(r){
                        if(r.data != bank_code){
                            window.location.reload();
                        }
                        if(r.code == 0){
                            window.location.reload();
                        }
                    }
                })
            }, 2000);

            // 公告
            let system_notification = true;
            if (system_notification) {
                //ajax
                $.ajax({
                    url:'/notice/show/1',
                    type:'get',
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN':"{{csrf_token()}}"
                    },
                    success:function(msg){
                        if(msg.code == 1){
                            var notice = msg.msg.content
                            weui.alert('<span class="title">尊敬的会员：</span><p class="content">'+notice+'</p>', function(){
                                system_notification = false;
                            },{ 
                                title: '系统通知',
                                className : 'system-notification'
                            });
                        }
                    }
                })
            }
        });
    </script>
</script>


<script type="text/html" id="tpl_bank_list">
    <div class="page js_show">
        <div class="page__hd">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__hd" onclick="javascript:window.history.back(-1);">返回</div>
                    <div class="weui-cell__bd">银行卡列表</div>
                    <div class="weui-cell__ft js_item" data-id="bank_create">添加</div>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">请使用以下绑定的银行卡进行转账</div>
        <div class="page__bd">
            <div class="weui-cells" id="bank_list" ref="bank_list">
                <div class="weui-cell" v-for="(v,k) in list" v-if="k < 5">
                    <div class="weui-cell__hd">
                        <div class='ui-banklogo' v-bind:class="setClass(v.card_code)"></div>
                    </div>
                    <div class="weui-cell__bd">
                        <p>${ v.bank_addr } (<span>尾号${ setBank(v.bank_code) }</span>)</p>
                    </div>
                    <div class="weui-cell__ft">
                        <div class="weui-btn weui-btn_mini weui-btn_primary make_up" v-if="v.cert_status == 2" v-bind:data-id="v.id">补单</div>
                        
                        <span class="danger" v-if="v.cert_status == 0">未验证:${ v.cert_monney }</span>
                    </div>
                </div>

                <!-- <div class="weui-cell" v-if="list.length > 5" >
                    <div class="weui-cell__bd" style="color:red;text-align: center;font-weight: 700;">
                        以下银行卡必须完成金额验证<br>否则不能自动到账
                    </div>
                </div>
                <div class="weui-cell" v-for="(v,k) in list" v-if="k >= 5">
                    <div class="weui-cell__hd">
                        <div class='ui-banklogo' v-bind:class="setClass(v.card_code)"></div>
                    </div>
                    <div class="weui-cell__bd">
                        <p>{ v.bank_addr } (<span>尾号{ setBank(v.bank_code) }</span>)</p>
                    </div>
                    <div class="weui-cell__ft">
                        <div class="weui-btn weui-btn_mini weui-btn_primary make_up" v-if="v.cert_status == 1" v-bind:data-id="v.id">补单</div>
                        
                        <span class="danger" v-if="v.cert_status != 1">未验证:{ v.cert_money }</span>
                    </div>
                </div> -->

                <!-- <div class="weui-cell" v-if="ret_list.length" >
                    <div class="weui-cell__bd" style="color:#19ACF7;text-align: center;font-weight: 700;">
                        &darr;&darr;&darr;&nbsp;找回银行卡列表&nbsp;&darr;&darr;&darr;
                    </div>
                </div>
                <div class="weui-cell" v-for="v in ret_list">
                    <div class="weui-cell__hd">
                        <div class='ui-banklogo' v-bind:class="setClass(v.bank_member_banks.card_code)"></div>
                    </div>
                    <div class="weui-cell__bd">
                        <p>{ v.bank_member_banks.bank_addr } (<span>尾号{ setBank(v.bank_member_banks.bank_code) }</span>)</p>
                    </div>
                    <div class="weui-cell__ft">
                        
                        
                        <span class="danger">待打款验证:{ v.cert_money }</span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <script>
        $(function(){

            $('.js_item').on('click', function(){
                let id = $(this).data('id');
                window.pageManager.go(id);
            });

            let loading = weui.loading('正在加载', {
                className : 'load_bank'
            });
            // 加载银行卡
            let bank_list = new Vue({
                delimiters: ['${', '}'],
                el: "#bank_list",
                data: {
                    list: [],
                    ret_list: [],
                    isActive: true,
                    ok: true,
                },
                methods: {
                    setClass(val){
                        let obj = {}
                        obj[`ui-banklogo-s-${val}`] = true
                        return obj
                    },
                    setBank(val){
                        return val.substr(-4);
                    },
                    setStatus(val){
                        return val == 1 ? 'success' : 'danger';
                    },
                    make_up(id){
                        console.log(id);
                    }
                }
            });

            $.get("/bank/get_user_banks",function(r){
                console.log(r);
                bank_list.list = r.list;
                bank_list.ret_list = r.ret_list;

                loading.hide();
            });

            let make_up = false;
            $('#bank_list').on('click', '.make_up', function(){
                let id = $(this).data('id');
                if (make_up) return;
                $.post("/bank/make_up", {
                    '_token' : "{{csrf_token()}}",
                    'id' : id
                }, function(r){
                    if (r.code == 1) {
                        weui.toast(r.msg, 1000);
                    }else if(r.code == -1){
                        weui.topTips(r.msg);
                    }
                });
            });

            // 离开
            $(window).on('hashchange', function(){
                loading.hide();
            });
        });
    </script>
</script>


<script type="text/html" id="tpl_bank_create">
    <div class="page js_show">
        <div class="page__hd">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__hd" onclick="javascript:window.history.back(-1);">返回</div>
                    <div class="weui-cell__bd">添加银行卡</div>
                </div>
            </div>
        </div>
        <div class="page__bd">
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">卡号</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="tel" name="bank_code" autocomplete="off" maxlength="24" placeholder="请输入银行卡号">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">银行</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" name="bank_addr" autocomplete="off" placeholder="如若无法识别，请手动输入">
                    </div>
                </div>
            </div>

            <div class="weui-btn-area">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="subForm">添加银行卡</a>
                <!-- <a class="weui-btn weui-btn_primary" href="javascript:" id="retrieve">找回银行卡</a> -->
            </div>
        </div>
    </div>

    <script>
        $(function(){
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
            $('input[name="bank_code"]').on('input propertychange', function() {
                if (isAndroid) {
                    return false;
                }
                let bank_code = $(this).val();
                bank_code = bank_code.replace(/\s/g, '');
                // 识别银行卡
                getBankBin(bank_code,function(err, data){
                    $('input[name="bank_addr"]').val( data ? data.bankName : '' );
                });
                bank_code = bank_code.replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1 ");
                $(this).val(bank_code);
            });

            let loading;
            $('#subForm').on('click', function(){
                loading = weui.loading('正在核对卡号', {
                    className: 'check-bank'
                });
                let bank_code = $('input[name="bank_code"]').val();
                bank_code = bank_code.replace(/\s/g, '');

                let bank_addr = $('input[name="bank_addr"]').val();
                let cardData = '';
                
                
                if (!trim(bank_addr)) {
                    loading.hide();
                    weui.topTips('请输入银行名称');
                    return false;
                }

                $.post("/bank/create", {
                    'bank_addr' : bank_addr,
                    'bank_code' : bank_code,
                    'cardCode' : cardData.bankCode ? cardData.bankCode : '',
                    '_token' : '{{csrf_token()}}'
                }, function(r){
                    loading.hide();
                    if (r.code === 1) {
                        weui.confirm('是否继续添加？',
                        function(){
                            $('input[name="bank_code"]').val('');
                            $('input[name="bank_addr"]').val('');
                        },
                        function(){
                            window.location.href = '/bank';
                        }, {
                            title: '添加成功'
                        });
                    }else if (r.code === -1) {
                        weui.topTips(r.msg);
                    }else if (r.code === -2) {
                        weui.topTips(r.msg);
                    }
                });
            });
            $('#retrieve').on('click', function(){
                loading = weui.loading('loading');
                let bank_code = $('input[name="bank_code"]').val();
                bank_code = bank_code.replace(/\s/g, '');

                let bank_addr = $('input[name="bank_addr"]').val();
                let cardData = '';
                
                
                if (!trim(bank_addr)) {
                    loading.hide();
                    weui.topTips('请输入银行名称');
                    return false;
                }

                $.post("/bank/retrieve", {
                    'bank_addr' : bank_addr,
                    'bank_code' : bank_code,
                    '_token' : '{{csrf_token()}}'
                }, function(r){
                    loading.hide();
                    if (r.code === 1) {
                        weui.confirm('是否继续添加？',
                        function(){
                            $('input[name="bank_code"]').val('');
                            $('input[name="bank_addr"]').val('');
                        },
                        function(){
                            window.location.href = '/bank';
                        }, {
                            title: '操作成功'
                        });
                    }else if (r.code === -1) {
                        weui.topTips(r.msg[0]);
                    }else if (r.code === -2) {
                        weui.topTips(r.msg);
                    }
                });
            });
            // 删除左右两端空格
            function trim(str){
                return str.replace(/(^\s*)|(\s*$)/g, "");
            }
        });
    </script>
</script>
@endsection