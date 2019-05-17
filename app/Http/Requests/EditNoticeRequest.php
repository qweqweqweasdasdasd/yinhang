<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditNoticeRequest extends FormRequest
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
            'content'=>'required|max:200'
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
            'content.required'=>'公告必须存在!',
            'content.max'=>'通知公告不得超出200个字符!'
        ];
    }
}
