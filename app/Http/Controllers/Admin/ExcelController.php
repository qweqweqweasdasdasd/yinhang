<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\OrderImportCCB;
use App\Imports\OrderImportCMB;
use App\Imports\OrderImportCIB;
use App\Imports\OrderImportICBC;
use Maatwebsite\Excel\Facades\Excel;    //https://laravel-excel.maatwebsite.nl/3.1/imports/collection.html
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    //允许存在的格式
    protected $allow_ext = ['xls','xlsx'];

    /**
     * 显示银行存款导入页面
     */
    public function index()
    {
        return view('admin.excel.index');
    }

    /**
     * 导入excel
     */
    public function import(Request $request)
    {
        //获取到上传的文件
        $file = $request->file('file');

        //判断上传文件的后缀以及是什么银行
        $ext = $file->getClientOriginalExtension(); //xls xlsx
        $bank_name = $file->getClientOriginalName(); //文件名称
        if(!in_array($ext,$this->allow_ext)){
            return ['code'=>config('code.response.error'),'msg'=>'导入数据的类型为xls'];
        }

        //建设企业银行  A058171TB_ND65587100000526048100 CCB
        if(strpos($bank_name,'A058171TB_ND') !== false){
            $this->format_CCB($file);
            return ['code'=>config('code.response.success')];
        };

        //工商企业银行  historydetail2552 ICBC
        if(strpos($bank_name,'historydetai') !== false){
            $this->format_ICBC($file);
            return ['code'=>config('code.response.success')];
        }

        //招商企业银行 537900768010505-20190104-20190104 CMB
        if(strpos($bank_name,'537900768010505') !== false){
            $this->format_CMB($file);
            return ['code'=>config('code.response.success')];
        }

        //兴业个人银行 TransDetail1546652970656 CIB
        // if(strpos($bank_name,'TransDetail') !== false){
        //     $this->format_CIB($file);
        //     return ['code'=>config('code.response.success')];
        // }

        return ['code'=>config('code.response.error')];
    }

    /**
     * 招商银行处理数据 CMB
     * return array
     */
    public function format_CMB($file)
    {
        //获取到数据之后 格式化 return array    
        //默认使用xlsx格式
        Excel::import(new OrderImportCMB, request()->file('file'),null,\Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * 工商银行处理数据 ICBC
     * return array
     */
    public function format_ICBC($file)
    {
        //获取到数据之后 格式化 return array
        Excel::import(new OrderImportICBC, request()->file('file'));
    }

    /**
     * 建设银行处理数据 CCB
     * return array
     */
    public function format_CCB($file)
    {
        //获取到数据之后 格式化 return array
        Excel::import(new OrderImportCCB, request()->file('file'));
    }

}
