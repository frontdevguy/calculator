<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CharactersRule implements Rule
{
   
    /**
     * Ensure all character in string are valid
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $expression)
    {
        return preg_match("/^[0-9.)+\(\-%÷×]+$/i", $expression);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Character Expression';
    }
}
