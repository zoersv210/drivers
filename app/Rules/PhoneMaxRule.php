<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneMaxRule implements Rule
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
        return $this->isLessMax($value);
    }

    protected function isLessMax($value)
    {
        return strlen($value) <= 12;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone must not contain more than 12 characters';
    }
}
