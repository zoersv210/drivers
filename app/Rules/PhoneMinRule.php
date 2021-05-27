<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneMinRule implements Rule
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
        return $this->isPhone($value);
    }

    protected function isPhone($value)
    {
        return $this->isMoreMin($value);
    }

    protected function isMoreMin($value)
    {
        return  strlen($value) >= 9;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone must contain more than 8 characters';
    }
}
