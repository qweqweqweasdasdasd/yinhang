<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\NoticeRepository;
use App\Http\Requests\EditNoticeRequest;

class NoticeController extends Controller
{
    //公告仓库
    protected $baseRepository;
    protected $noticeRepository;

    //构造函数
    public function __construct(NoticeRepository $noticeRepository,BaseRepository $baseRepository)
    {
        $this->noticeRepository = $noticeRepository;
        $this->baseRepository = $baseRepository;
        $this->baseRepository->model = 'notice';
        $this->baseRepository->id = 'n_id';
    }
    /**
     * 加载公告信息
     */
    public function jiazai(Request $request)
    {
        $notice = $this->noticeRepository->noticeFind($request->route('notice'));
        
        return ['code'=>config('code.response.success'),'msg'=>$notice];
    }

    /**
     * 显示公告信息编辑
     */
    public function edit($id)
    {
        $notice = $this->baseRepository->getOneById($id);

        return view('admin.notice.edit',compact('notice'));
    }

    /**
     * 更新公告信息
     */
    public function update(EditNoticeRequest $request, $id)
    {
        $this->baseRepository->updateDataById($request->all(),$id);

        return ['code'=>config('code.response.success')];
    }

}
