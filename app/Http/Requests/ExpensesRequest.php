<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class ExpensesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'name' =>'required',
            'sallary' => 'required',
        
            'date_expenses'=>'required',
        ];
    }


    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'msg'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));

    }
    public function messages()
    {
        return [
            'name.required' =>'من فضلك ادخل اسم الصنف',
            'sallary.required'=>'من فضلك ادخل السعر',
            
            'date_expenses.required'=>'من فضلك ادخل التاريخ',
        ];
    }


}
