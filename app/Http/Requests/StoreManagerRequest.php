<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagerRequest extends FormRequest
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
            'mg_name'=>'required|max:10',
            'password'=>'required|confirmed',
            'mg_status'=>'required|integer',
            'r_id'=>'required|integer',
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
            'mg_name.required'=>'管理员名称必须存在!',
            'mg_name.max'=>'管理员名称不得超过20个字符!',
            'password.required'=>'密码必须存在!',
            'password.confirmed'=>'初始密码和确认密码不符!',
            'mg_status.required'=>'管理员状态必须存在!',
            'mg_status.integer'=>'管理员状态格式不对!',
            'r_id.required'=>'角色必须选择的哦!',
            'r_id.integer'=>'角色格式不对!',
            'desc.max'=>'备注不得超出200个字符!'
        ];
    }
}
