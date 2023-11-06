<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class repcustomersRequest extends FormRequest
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
            //'customer_code' => 'required',
            'order_date_form' => 'required',
            'order_date_to' => 'required',
            //'parent_account_number' => 'required_if:is_main,0',
            
        ];
    }

    public function messages()
    {
        return [
            //'customer_code.required' => 'اسم المورد مطلوب',
            'order_date_form.required' => 'بداية الفترة مطلوب',
            'order_date_to.required' => '  نهاية الفترة مطلوب ',
           

        ];
    }
}
