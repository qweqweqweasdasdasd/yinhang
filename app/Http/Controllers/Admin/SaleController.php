<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SaleRepository;
use App\Repositories\BaseRepository;

class SaleController extends Controller
{
    //优惠仓库
    protected $saleRepository;
    protected $baseRepository;

    //构造函数
    public function __construct(SaleRepository $saleRepository,BaseRepository $baseRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->baseRepository = $baseRepository;
        $this->baseRepository->model = 'sale';
        $this->baseRepository->id = 'id';
    }

    /**
     * 优惠配置列表
     */
    public function index()
    {
        $sale = $this->saleRepository->getSale();

        return view('admin.sale.index',compact('sale'));
    }

    /**
     * 新建配置页面
     */
    public function create()
    {
        return view('admin.sale.create');
    }

    /**
     * 保存配置数据
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /** 
     * 编辑配置页面 !!
     */
    public function edit($id)
    {
        $sale = $this->baseRepository->getOneById($id);

        return view('admin.sale.edit',compact('sale'));
    }

    /**
     * 更新配置数据 !!
     */
    public function update(Request $request, $id)
    {
        $this->baseRepository->updateDataById($request->all(),$id);
        
        return ['code'=>config('code.response.success')];
    }

    /**
     * 修改状态
     */
    public function reset(Request $request)
    {
        $data = $request->all();
        $this->baseRepository->common_reset_status($data['id'],$data['status'],'status');
        
        return ['code'=>config('code.response.success')];
    }

    /**
     * 删除配置文件
     */
    public function destroy($id)
    {
        
    }


}
