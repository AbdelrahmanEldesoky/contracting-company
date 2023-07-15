<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class RegisterRequest extends FormRequest
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
            'mobile' => 'required',
            'password' => 'required',
            'name'=>'required',
            'email'=>'required|email',
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
            'password.required' => 'كلمة المرور مطلوبة.' ,
            'name.required'=>'ادخل الاسم',
            'email.required'=>'من فضلك ادخل البريد الالكتروني',
            'email.email' =>' البريد الالكتروني خاطئ'
        ];
    }
}
