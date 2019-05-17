<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'r_name' => 'required|between:2,6',
            'desc' => 'between:4,150'
        ];
    }

    /**
     * 报错信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'r_name.required' => '角色名称必须填写!',
            'r_name.between' => '角色大于2小于6个字符!',
            'desc.between' => '备注大于4小于150个字符!'
        ];
    }
}
