<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaluationRequest;
use ChrisKonnertz\StringCalc\StringCalc as Calculator;
use Illuminate\Support\Facades\Response;

class CalculatorController extends Controller
{
    //The validated expression string
    private $expression;
    
    /**
     * Starts the calculation process by validating request
     * @param $request
     * @return mixed
     */
    public function evaluate(EvaluationRequest $request) 
    {
        //replace the division and multiplication symbol on validated expression string
        $this->setExpressionString(str_replace('÷','/',str_replace('×','*',$request->expression)));

        //collects the result of the calculated expression string
        $result = $this->calculate();

        //checks for math error
        if($result === false) {
            return Response::make("",503);
        }

        //returns result in json format
        return response()->json(['result'=>$result]);
    }

    /**
     * Does the main calculation on the validated expression string
     * @return mixed
     */
    private function calculate() 
    {
        $this->percentageValue();
        try {
            $caculator = new Calculator();
            $expression = $this->getExpressionString();
            $result = $caculator->calculate($expression); 
            return number_format($result,6) + 0; //prevent unecessary zeros after decimal
        } catch (\Exception $exception) { //handles exception incase of Math Error
            return false;
        }
    }

    /**
     * Calculates the percentage value present in the expression string
     * @return mixed
     */
    private function percentageValue() 
    {
        //matches all percentage values in array to be replaced by computated value
        preg_match_all("/([\d\.]+)(?:%)/", $this->getExpressionString(),$matches);
        $percentage_symbol_values = ($matches[1]);

        if (count($percentage_symbol_values) > 0) {
            foreach ($percentage_symbol_values as $percentage_symbol_value) {
                $expression = $this->getExpressionString();
                $this->setExpressionString(str_replace($percentage_symbol_value.'%',(float) $percentage_symbol_value / 100, $expression));
            }
        }
    }
    
    /**
     * Returns the expression string
     * @return string
    */
    private function getExpressionString() {
        return $this->expression;
    }

    /**
     * Sets the expression string
     * @param string $expression
    */
    private function setExpressionString(string $expression) {
        $this->expression = $expression;
    }
}
