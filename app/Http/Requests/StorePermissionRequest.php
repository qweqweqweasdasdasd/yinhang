<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ps_name'=>'required|max:100',
            'ps_pid'=>'required|integer',
            'ps_c'=>'required|max:100',
            'ps_a'=>'required|max:100',
            'ps_route'=>'required|max:100',
            'desc'=>'max:200'
        ];
    }

    /**
     * 自定义错误信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'ps_name.required'=>'权限名称必须存在!',
            'ps_name.max'=>'权限名不得大于100个字符!',
            'ps_pid.required'=>'权限上级id必须存在!',
            'ps_pid.integer'=>'权限上级id格式不对哦!',
            'ps_c.required'=>'权限控制器必须存在!',
            'ps_c.max'=>'权限不得大于100个字符!',
            'ps_a.required'=>'方法必须存在!',
            'ps_a.max'=>'方法不得大于100个字符!',
            'ps_route.required'=>'路由必须存在!',
            'ps_route.max'=>'路由不得大于100个字符!',
            'desc.max'=>'备注不得大于200个字符!'
        ];
    }
}
