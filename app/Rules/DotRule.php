<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Rules\GeneralRule;

class DotRule extends GeneralRule implements Rule
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
        $expression = $value;
        $invalid_surrounded_characters = ['-','+','×','÷','%','.',')','('];
        $characters = $this->strSplitUnicode($expression);
        $pass = true;
        foreach($characters as $index=>$character) {
            if($character === '.') {
                if(isset($characters[$index-1]) && in_array($characters[$index-1],$invalid_surrounded_characters)){
                    $pass = false;
                    break;
                }
            }else {
                continue;
            }
        }
        return $pass;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Dot Expression';
    }
}
