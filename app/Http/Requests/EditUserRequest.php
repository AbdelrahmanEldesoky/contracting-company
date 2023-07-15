<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades;

class EditUserRequest extends FormRequest
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
            'mobile' => 'required',
            'password' => 'required',
            'name'=>'required',
            'person_id'=>'required',
            'address'=> 'required',
        ];
    }
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'msg'   => '',
           // 'user'    => null
        ]));

    }


    public function messages()
    {
        return [
            'mobile.required' => 'ادخل رقم الهاتف',
            'password.required' => 'كلمة المرور مطلوبة.' ,
            'name.required'=>'ادخل الاسم',
            'address.required'=> 'من فضلك ادخل عنوان المشرف',
            'person_id.required'=> 'من فضلك ادخل رقم هوية المشرف',
        ];
    }
}
