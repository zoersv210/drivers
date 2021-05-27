<?php


namespace App\Http\Requests\Api;


use App\Rules\CodeLengthRule;
use App\Rules\PhoneLengthRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends FormRequest
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
            'code' => ['integer', 'required', new CodeLengthRule()],
            'phone' => ['integer', 'required', new PhoneLengthRule],
        ];
    }
}
