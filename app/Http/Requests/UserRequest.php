<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'name' => 'required',
            'Status' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'role' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'اسم المستخدم مطلوب',
            'name.required' => ' الاسم مطلوب',
            'Status.required' => '   الحالة مطلوب',
            'email.required' => '      الايميل مطلوب',
            'password.required' => '     كلمة المرور  مطلوب',
            'role.required'=>'     الوظيفة مطلوب',
            'photo.required' => '    الصورة مطلوب',


        ];
    }
}
