<?php

namespace App\Http\Requests\Api;


class CaptchaRequest extends FormRequest
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
            'phone_number' => 'required|phone:CN,mobile|unique:users,phone_number',
        ];
    }
}
