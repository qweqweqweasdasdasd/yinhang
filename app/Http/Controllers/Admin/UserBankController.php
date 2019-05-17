<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\ReceiptRepository;
use App\Repositories\UserBankRepository;

class UserBankController extends Controller
{
    //收款卡仓库
    protected $receiptRepository;
    protected $userBankRepository;
    protected $baseRepository;

    //构造函数
    function __construct(ReceiptRepository $receiptRepository,UserBankRepository $userBankRepository,BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
        $this->baseRepository->model = 'bank';
        $this->baseRepository->id = 'id';
        $this->receiptRepository = $receiptRepository;
        $this->userBankRepository = $userBankRepository;
    }

    //前台管理--用户新增银行卡信息
    public function create(Request $request)
    {
        $data = $request->all();
        $str = explode(';', $request->header('cookie'))[0];
        $token = str_replace('=','',$str);
        $data['u_id'] = $this->receiptRepository->get_user($token)->u_id;
        // 相同的卡号已存在只能存在一个  -1
        if($this->userBankRepository->bankCode_user_exist($data)){
            return ['code'=>-1,'msg'=>'卡号已存在'];
        }
        // 根据银行卡账号查询订单内到账失败的修改用户与银行对应表状态为 2

        if($this->userBankRepository->check_budan_bank_code_reset_cert_status($data)){
            $data['cert_status'] = 2;
        };
        
        //?? -2 ??
        $this->userBankRepository->create_bank_info($data);
        return ['code'=>1];
    }

    /**
     *  用户银行卡列表
     */
    public function index(Request $request)
    {
        error_reporting(0);
        $data['bank_code'] = !empty($request->get('bank_code')) ? $request->get('bank_code') : '';
        $data['username'] = !empty($request->get('u_id')) ? $request->get('u_id') : '';
        $data['u_id'] = $this->userBankRepository->get_username_by_id($data['username']);
        $userbank = $this->userBankRepository->get_userbank_data($data);
        $count = $this->userBankRepository->count($data);

        return view('admin.userbank.index',compact('userbank','count','data'));
    }

    /**
     *  显示用户银行卡编辑
     */
    public function edit($id)
    {
        $info = $this->baseRepository->getOneById($id);
        //dump($info);
        return view('admin.userbank.edit',compact('info'));
    }

    /**
     *  更新用户银行卡数据
     */
    public function update(Request $request, $id)
    {
        $data = array_except($request->all(),['cert_status','cert_monney']);
        $this->baseRepository->updateDataById($data,$id);
        
        return ['code'=>config('code.response.success')]; 
    }

    /**
     *  删除用户银行卡数据
     */
    public function destroy($id)
    {
        $this->baseRepository->common_delete($id);
        
        return ['code'=>config('code.response.success')];
    }
}
