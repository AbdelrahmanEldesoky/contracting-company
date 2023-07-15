<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class BudgetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
          
            'value' => 'required',
           
           ];

    }
    public function failedValidation(Validator $validator)

    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'msg'   => 'Validation errors',
            'data' => $validator->errors()
        ]));

    }
    public function messages()
    {
        return [
            'value.required' => 'ادخل قيمة الدفعة ',
           
        ];
    }
}
