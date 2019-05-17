<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginManagerRequest extends FormRequest
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
            'mg_name' => 'required|between:2,12',
            'password' => 'required|between:2,12',
            'code' => 'required|captcha',
        ];
    }

    /**
     * 错误信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'mg_name.required' => '管理员名称必须存在!',
            'mg_name.between' => '管理员大于2到12个字符!',
            'password.required' => '密码必须存在!',
            'password.between' => '密码大于2到12个字符!',
            'code.required' => '验证码必须存在!',
            'code.captcha' => '验证码不正确!',
        ];
    }
}
