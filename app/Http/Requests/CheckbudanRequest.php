<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckbudanRequest extends FormRequest
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
            'input_name' => 'required|max:20',
            'money' => 'required|numeric',
            'w_trade_no' => 'required|max:50',
        ];
    }

    /**
     * 自定义报错信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'input_name.required' => '会员账号必须填写!',
            'input_name.max' => '会员账号不得超出20个字符!',
            'money.required' => '金额必须填写!',
            'money.numeric' => '金额格式为数值!',
            'w_trade_no.required' => '订单号必须存在!',
            'w_trade_no.max' => '订单号不得超出50个字符!',
        ];
    }
}
