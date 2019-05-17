<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Order;
use App\UserBank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Http\Requests\UpdateBudanRequest;

class OrderController extends Controller
{
    //管理仓库
    protected $orderRepository;

    //构造函数
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    /**
     * 订单管理显示
     */
    public function index(Request $request)
    {
        $data['bank_account'] = !empty($request->get('bank_account'))?$request->get('bank_account'):'';
        $data['order_no'] = !empty($request->get('order_no'))?$request->get('order_no'):'';
        $data['username'] = !empty($request->get('username'))?$request->get('username'):'';
        
        $orders = $this->orderRepository->getOrders($data);
        $count = $this->orderRepository->count($data);
        $total = $this->orderRepository->total($data);

        return view('admin.order.index',compact('orders','count','data','total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->orderRepository->get_order($id);
        //dump($order);
        return view('admin.order.edit',compact('id','order'));
    }

    /**
     * 指定订单号进行补单
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        //判断当前订单号状态 是否上分成功
        $order = $this->orderRepository->get_order($request->get('o_id'));
        //排除 这两种情况请求第四方接口失败或者会员账号银行卡对应异常的情况下
        if($order->status == 1 || $order->status == 3 || $order->status == 5 || $order->status == 6){
            return ['code'=>-1,'msg'=>'只有[请求第四方接口失败]或者[会员账号银行卡对应异常]的情况下,才可以补单'];
        };

        //获取到用户id 是否存在
        $user = Bank::where('username',$request->get('username'))->first();
        if(!count($user)){
            return ['code'=>-1,'msg'=>'没有该会员的记录!,请到银行存款网站进行绑定银行卡!'];
        }

        //给用户创建一个绑定银行卡信息
        $data = [
            'u_id' => $user->u_id,
            'bank_code' => $request->get('bank_code')
        ];

        //判断给用户创建一个绑定的银行卡信息是否存在
        if(!UserBank::where('bank_code',$data['bank_code'])->count()){
            UserBank::create($data);
        };
        
        //调用接口操作补单
        try {
            
            $run_disifang = new \App\Http\Controllers\Server\DisifangController;
            app('log')->info('调用接口操作补单');
            $run_disifang->run_disifang($request->get('username'),$order->money,$order->order_no,$order->bank_account,'budan');
        } catch (\Exception $e) {
            return ['code'=>-1,'msg'=>$e->getMessage()]; 
        }
        
        return ['code'=>1,'msg'=>'成功到账!'];
    }

    // public function update(UpdateBudanRequest $request,$id)
    // {
    //     //会员账号 $request->get('username');
    //     //银行地址 $request->get('bank_addr');
    //     //银行姓名 $request->get('bank_name');
    //     //订单信息  $id
    
    //     $data['bank_addr'] = !empty($request->get('bank_addr'))? trim($request->get('bank_addr')):'';
    //     $data['bank_name'] = !empty($request->get('bank_name'))? trim($request->get('bank_name')):'';

    //     $order = $this->orderRepository->get_order($id);
        
    //     $u_id = Bank::where('username',$request->get('username'))->value('u_id');
    //     //没有登录记录的会员
    //     if(!$u_id){
    //         return ['code'=>-1,'msg'=>'没有该会员的记录!,请到银行存款网站进行绑定银行卡!'];
    //     }
    //     $data['bank_code'] = $order->bank_account;
    //     $data['u_id'] = $u_id;
    //     $data['cert_status'] = 1;
    //     $data['cert_monney'] = $order->money;

    //     dump($data);die();

    //     //如果是银行卡信息对 钱的笔数不对 更新
    //     if(UserBank::where('bank_code',$data['bank_code'])->where('cert_status','<>',0)->count()){
    //         return ['code'=>-1,'msg'=>'当前会员银行卡状态ok,存款是会自动到账的,请核实一下,是否需要手动存款!'];
    //     }
    //     //调用第四方类
    //     $run_disifang = new \App\Http\Controllers\Server\DisifangController;
    //     if($order->status == 3){
    //         return ['code'=>-1,'msg'=>'已经到账了哦!'];
    //     }
    //     $run_disifang->run_disifang($request->get('username'),$order->money,$order->order_no,$order->bank_account,'budan');
    //     // 创建用户与银行卡关系信息
    //     UserBank::create($data);
    //     return ['code'=>1,'msg'=>'成功到账!'];
    // }

}
