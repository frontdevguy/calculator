<?php

namespace Tests\Unit;

use Tests\TestCase;

class CalculatorTest extends TestCase
{
    /** @test  */
    public function calculator_can_be_accessed()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test  */
    public function expression_string_is_required_for_evaluation()
    {
        $response = $this->json('POST',route('evaluate-expression'));
        $response->assertStatus(400);
        $response->assertSeeText("Expression string is required");
    }

    /** @test  */
    public function expression_string_is_invalid_with_non_completing_brackets()
    {
        $payload = [ 'expression' => "((" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(400);
        $response->assertSeeText("Invalid Bracket Expression");
    }

    /** @test  */
    public function expression_string_is_invalid_with_operators_side_by_side()
    {
        $payload = [ 'expression' => "8++1" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(400);
        $response->assertSeeText("Invalid Operator Expression");
    }

     /** @test  */
     public function expression_string_is_invalid_with_empty_brackets()
     {
        $payload = [ 'expression' => "()" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(400);
        $response->assertSeeText("Invalid Bracket Expression");
     }

    /** @test  */
    public function expression_string_is_invalid_with_closing_bracket_not_followed_by_an_operator_when_not_the_end()
    {
        $payload = [ 'expression' => "(6+1)(4)" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(400);
        $response->assertSeeText("Invalid Bracket Expression");
    }

     /** @test  */
    public function expression_string_is_invalid_with_incorrect_use_of_dots()
    {
        $payload = [ 'expression' => "4..1+1" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(400);
        $response->assertSeeText("Invalid Dot Expression");
    }

    /** @test  */
    public function result_is_obtained_if_expression_string_is_passed_correctly()
    {
        $payload = [ 'expression' => "(6+1)+(4)" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(200);
        $response->assertJsonStructure(['result']);
    }

    /** @test  */
    public function expression_string_is_evaluated_using_mathmatical_rule_BODMAS()
    {
        $payload = [ 'expression' => "(6+1)×(4-2)+1" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(200);
        $response->assertExactJson(['result' => 15]);
    }

    /** @test  */
    public function expression_string_is_invalid_if_wrong_characters_are_passed()
    {
        $payload = [ 'expression' => "??(6+1)×(4-2)+1" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(400);
        $response->assertSeeText("Invalid Character Expression");
    }

    /** @test  */
    public function results_in_math_error_when_expression_is_badly_formated()
    {
        $payload = [ 'expression' => "40%%" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(503);
    }

    /** @test  */
    public function can_evaluate_addition_operator()
    {
        $payload = [ 'expression' => "1+4" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(200);
        $response->assertExactJson(['result' => 5]);
    }

    /** @test  */
    public function can_evaluate_substraction_operator()
    {
        $payload = [ 'expression' => "1-4" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(200);
        $response->assertExactJson(['result' => -3]);
    }

    /** @test  */
    public function can_evaluate_percentage_operator()
    {
        $payload = [ 'expression' => "100%" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(200);
        $response->assertExactJson(['result' => 1]);
    }

    /** @test  */
    public function can_evaluate_operations_in_brackets()
    {
        $payload = [ 'expression' => "(4×0.1)-1" ];
        $response = $this->json('POST',route('evaluate-expression'),$payload);
        $response->assertStatus(200);
        $response->assertExactJson(['result' => -0.6]);
    }
}
