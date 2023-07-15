<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterWorkerRequest extends FormRequest
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
            'name' => 'required|string',
            'mobile' => 'required|unique:workers,mobile',
            'sallary'=>'required',
            'person_id'=> 'required',
            'password' =>'required'
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
           
            'mobile.required' => 'ادخل رقم الهاتف',
           
            'mobile.unique' => 'رقم الهاتف مكرر من قبل',
            'password.required' => 'كلمة المرور مطلوبة.' ,
            'name.required'=>'ادخل الاسم',
            'address.required'=> 'من فضلك ادخل عنوان المشرف',
            'person_id.required'=> 'من فضلك ادخل رقم هوية المشرف',
            'sallary.required' => 'ادخل يومية  العامل',
       ];
    }
}
