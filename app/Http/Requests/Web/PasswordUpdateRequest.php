<?php

namespace App\Http\Requests\Web;


use Illuminate\Foundation\Http\FormRequest;


class PasswordUpdateRequest extends FormRequest
{

    public function rules()
    {

        return [
            'password' => ['required', 'min:6', 'max:50'],
            'confirm_password' => ['same:password'],
        ];
    }
}
