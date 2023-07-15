<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class PaymentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'worker_id' => 'required',
            'value' => 'required',
        
            'date_at' => 'required'
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

            'worker_id.required' => 'من فضلك اختار العامل',
            'value.required' => 'ادخل قيمة السلفة ',
           
            'date_at.required' => 'من فضلك قم بادخل التاريخ'
        ];
    }
}
