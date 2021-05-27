<?php

namespace App\Http\Requests\Api;

use App\Rules\PhoneLengthRule;
use Illuminate\Foundation\Http\FormRequest;

class StartLoginRequest extends FormRequest
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

    public function rules()
    {
        return [
            'phone' => ['required', new PhoneLengthRule, 'integer'],
        ];
    }
}
