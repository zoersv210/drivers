<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CodeLengthRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->isCode($value);
    }

    protected function isCode($value)
    {
        return $this->isLength($value);
    }

    protected function isLength($value)
    {
        return  strlen($value) == 6;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Code length is incorrect.';
    }
}
