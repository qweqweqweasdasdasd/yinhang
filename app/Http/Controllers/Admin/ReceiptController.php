<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\ReceiptRepository;
use App\Http\Requests\StoreReceiptRequest;

class ReceiptController extends Controller
{
    //公用仓库
    protected $baseRepository;
    protected $receiptRepository;

    //构造函数
    public function __construct(BaseRepository $baseRepository,ReceiptRepository $receiptRepository)
    {
        $this->baseRepository = $baseRepository;
        $this->receiptRepository = $receiptRepository;
        $this->baseRepository->model = 'receipt_bank';
        $this->baseRepository->id = 'b_id';
    }
    
    /**
     * 收款银行卡列表
     */
    public function index()
    {
        $list = $this->receiptRepository->getReceipt();
        $count = $this->receiptRepository->count();

        return view('admin.receipt.index',compact('list','count'));
    }

    /**
     * 创建收款银行页面
     */
    public function create()
    {
        return view('admin.receipt.create');
    }

    /**
     * 创建银行保存
     */
    public function store(StoreReceiptRequest $request)
    {
        //是否重复
        if($this->receiptRepository->receiptUnique($request->all())){
            return ['code'=>config('code.response.error'),'error'=>'新增银行有重复!'];
        }
        $this->baseRepository->common_insert($request->all());
        return ['code'=>config('code.response.success')];
    }

    /**
     * 编辑收款银行卡页面
     */
    public function edit($id)
    {
        $info = $this->baseRepository->getOneById($id);

        return view('admin.receipt.edit',compact('info'));
    }

    /**
     * 更新收款银行卡数据
     */
    public function update(Request $request, $id)
    {
        $this->baseRepository->updateDataById($request->all(),$id);
        
        return ['code'=>config('code.response.success')];
    }

    /**
     * 删除收款银行卡数据
     */
    public function destroy($id)
    {
        $this->baseRepository->common_delete($id);

        return ['code'=>config('code.response.success')];
    }

    /**
     * 收款银行卡状态
     */
    public function reset(Request $request)
    {
        $data = $request->all();
        $this->baseRepository->common_reset_status($data['id'],$data['status'],'start_use_status');

        return ['code'=>config('code.response.success')];
    }
}
