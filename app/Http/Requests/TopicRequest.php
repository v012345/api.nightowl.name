<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
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
            //
            "user_id" => "required",
            "title" => "required|min:2",
            'body' => 'required|min:3',
            'category_id' => 'required|numeric',
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'title.min' => '标题必须至少两个字符',
    //         'body.min' => '文章内容必须至少三个字符',
    //     ];
    // }

    protected function failedValidation(Validator $validator)
    {
        // dd($validator);
        throw new HttpResponseException(response()->json(array("code" => 400, "msg" => "Wrong params", "error_detail" => $validator->errors()->all())));
    }
}
