<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\WcurdRepository;

class WechatController extends Controller
{
    //公告仓库
    protected $baseRepository;
    protected $wcurdRepository;

    //构造函数
    public function __construct(BaseRepository $baseRepository,WcurdRepository $wcurdRepository)
    {
        $this->baseRepository = $baseRepository;
        $this->baseRepository->model = 'qr';
        $this->baseRepository->id = 'qr_id';
        $this->wcurdRepository = $wcurdRepository;
    }

    /**
     * 微信qr配置页面
     */
    public function index()
    {
        //获取到当前的二维码
        error_reporting(0);
        $id = '1';
        $qr = $this->baseRepository->getOneById($id);

        return view('admin/wechat/index',compact('qr'));
    }

    /**
     * 上传微信二维码
     */
    public function upload(Request $request)
    {
        //上传的图片
        $image = $request->file('file');
        //组装新图片的名称
        $fileName = 'qr.'.$image->getClientOriginalExtension();    //qr.jpg
        $realPath = $image->getRealPath();  //临时文件路径
        //基础路径
        $basePath = './qr/'.mt_rand(10000,99999);
        //上传的图片格式验证
        if($image->isValid()){
            move_uploaded_file($realPath,$basePath.$fileName);  
            //更新一条数据到qr
            $id = '1';
            $rs = $this->baseRepository->updateDataById(['qr_path'=>ltrim($basePath.$fileName,'.')],$id);
            return ['code'=>config('code.response.success'),'path'=>$basePath.$fileName];
        }else{
            return ['code'=>config('code.response.error'),'msg'=>'上传图片失败,请重新上传!'];
        }
    }

    /**
     * 微信下单列表查询
     */
    public function w_order(Request $request)
    {
      error_reporting(0);
       $whereData['datemin'] = !empty($request->get('datemin')) ? $request->get('datemin') : "";
       $whereData['datemax'] = !empty($request->get('datemax')) ? $request->get('datemax') : "";
       $whereData['trade_no'] = !empty($request->get('trade_no')) ? $request->get('trade_no') :'';

       $worder = $this->wcurdRepository->getWorder($whereData);
       $count = $this->wcurdRepository->count_w_order($whereData);

       return view('admin.wechat.w_order',compact('worder','count','whereData'));
    }

    /**
     * 微信补单列表查询
     */
    public function budan(Request $request)
    {
       $whereData['trade_no'] = !empty($request->get('trade_no')) ? $request->get('trade_no') :'';
       $budan = $this->wcurdRepository->getBudan($whereData);
       $count = $this->wcurdRepository->count_budan($whereData);

       return view('admin.wechat.budan',compact('budan','count','whereData'));
    }
}
