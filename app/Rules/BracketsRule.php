<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Rules\GeneralRule;

class BracketsRule extends GeneralRule implements Rule
{
    
    /**
     * Determine if the expression has correct openning and closing brackets
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $expression)
    {
        //ensures all openning brackets are closed
        $pass_closing_brackets = $this->ensureClosingOfBrackets($expression);

        //ensures no empty brackets
        $pass_no_empty_brackets = $this->ensureNoEmptyBrackets($expression);

        //ensures all closing brackets are folllowed with an operator
        $pass_closing_brackets_followed_by_an_operator = $this->ensureClosingBracketsAreFollowedByAnOperator($expression);
        
        return ($pass_closing_brackets && $pass_no_empty_brackets && $pass_closing_brackets_followed_by_an_operator) ? true : false;
    }

    /**
     * ensures all openning brackets are closed
     * @param  string $expression
     * @return bool
     */
    private function ensureClosingOfBrackets(string $expression) {
        $len = strlen($expression);
        $stack = [];
        for ($i = 0; $i < $len; $i++) {
            switch ($expression[$i]) {
                case '(': array_push($stack, 0); break;
                case ')': 
                    if (array_pop($stack) !== 0)
                        return false;
                break;
                default: break;
            }
        }

        return (empty($stack)) ? true : false;
    }

    /**
     * ensures all openning brackets are closed with value(not empty)
     * @param  string $expression
     * @return bool
     */
    private function ensureNoEmptyBrackets(string $expression) {
        $invalid_surrounded_characters = [')','×','%','÷','.','+'];
        
        $invalid_surrounded_characters_opening = ['0','1','2','3','4','5','6','7','8','9','.'];
        $characters = $this->strSplitUnicode($expression);
        $pass = true;
        foreach($characters as $index=>$character) {
            if($character === '(') {
                if(isset($characters[$index+1]) && in_array($characters[$index+1],$invalid_surrounded_characters)){
                    $pass = false;
                    break;
                }
                if(isset($characters[$index-1]) && in_array($characters[$index-1],$invalid_surrounded_characters_opening)){
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
     * ensures all openning brackets are followed by an operator
     * @param  string $expression
     * @return bool
     */
    private function ensureClosingBracketsAreFollowedByAnOperator(string $expression) {
        $characters = $this->strSplitUnicode($expression);
        $pass = true;
        $invalid_surrounded_characters_closing = ['(','0','1','2','3','4','5','6','7','8','9','.'];
        foreach($characters as $index=>$character) {
            if($character === ')') {
                if(isset($characters[$index+1]) && in_array($characters[$index+1],$invalid_surrounded_characters_closing)){
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
        return 'Invalid Bracket Expression';
    }
}
