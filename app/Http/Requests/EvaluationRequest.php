<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Rules\CharactersRule;
use App\Rules\BracketsRule;
use App\Rules\OperatorsRule;
use App\Rules\DotRule;

class EvaluationRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['expression' => ['required',new CharactersRule(),new BracketsRule(),new OperatorsRule(),new DotRule()]];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'expression.required' => 'Expression string is required'
        ];
    }

    /**
     * Failed validation disable redirect
     *
     * @param Validator $validator
     * @return response bad request
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }

}
