<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades;

class RegisterUserRequest extends FormRequest
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
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required',
            'name'=>'required',
            'person_id'=>'required|unique:users,person_id',
            'address'=> 'required',
            'start_date' =>'required',
            'end_date'=>'required'
        ];
    }
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'رقم الهاتف او الهوية موجود بالفعل',
            'user'    => null
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
            'person_id.unique' => 'رقم الهوية مكرر من قبل',
        ];
    }
}
