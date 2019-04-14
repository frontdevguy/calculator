<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Rules\GeneralRule;

class OperatorsRule extends GeneralRule implements Rule
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
        $operators = ['-','+','×','÷','%'];
        $characters = $this->strSplitUnicode($expression);
        $pass = true;
        foreach($characters as $index=>$character) {
            if($character !== '%' && in_array($character,$operators)) {
                if(isset($characters[$index+1]) && in_array($characters[$index+1],$operators)){
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
        return 'Invalid Operator Expression';
    }
}
