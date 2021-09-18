<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            // "name" => "required|between:3,25|unique:users,name",
            // "account"=>"unique:users,account|between:6,25|regex:/^[A-Za-z0-9\-\_]+$/",
            "verification_key" => "required|string",
            "verification_code" => "required|string",
        ];
    }
    // public function attributes()
    // {
    //     return [
    //         'verification_key' => '短信验证码 key',
    //         'verification_code' => '短信验证码',
    //     ];
    // }
}
