<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceiptRequest extends FormRequest
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
            'bank_code'=>'required|between:16,23',
            'account_name'=>'required|max:20',
            'bank_name'=>'required|max:20',
            'bank_addr'=>'required|max:30',
            'start_use_status'=>'required|numeric',
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
            'bank_code.required'=>'银行卡卡号必须存在!',
            'bank_code.between'=>'银行卡号大于23位小于16位!',
            //'bank_code.integer'=>'银行卡号格式不对,必须为数字哦!',
            'account_name.required'=>'开户姓名必须存在!',
            'account_name.min'=>'开户姓名小于20个字符',
            'bank_name.required'=>'银行名称必须存在!',
            'bank_name.max'=>'银行名称不得超出20个字符',
            'bank_addr.required'=>'银行地址必须存在!',
            'bank_addr.max'=>'银行地址不得超出20个字符',
            'start_use_status.required'=>'银行开状态必须存在!',
            'start_use_status.numeric'=>'银行卡格式不对!',
        ];
    }
}
