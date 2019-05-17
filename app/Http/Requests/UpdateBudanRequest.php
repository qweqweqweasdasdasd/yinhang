<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudanRequest extends FormRequest
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
            'o_id'=>'required|integer',
            'username'=>'required|max:50',
            'bank_addr'=>'max:50',
            'bank_name'=>'required|max:100'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'o_id.required'=>'订单id必须存在!',
            'o_id.integer'=>'订单号格式不对!',
            'username.required'=>'会员账号必须存在!',
            'username.max'=>'会员账号不得超出50个字符!',
            'bank_addr.max'=>'银行卡不得超出50个字符',
            'bank_name.required'=>'银行名必须存在!',
            'bank_name.max'=>'银行名不得超出100个字符'
        ];
    }
}
