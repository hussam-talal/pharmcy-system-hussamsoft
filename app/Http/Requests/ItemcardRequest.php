<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemcardRequest extends FormRequest
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
         'name'=>'required',
         'item_type'=>'required',
         'items_categories_id'=>'required',
         'unit_id'=>'required',
          'retail_units_id'=>'required',
         'active'=>'required',
        ];
    }

    public function messages()
    {
        return [
        'name.required'=>'اسم الصنف مطلوب',
        'item_type.required'=>'نوع الصنف مطلوب',
        'items_categories_id.required'=>'فئة الصنف مطلوب',
        'unit_id.required'=>'الوحدة الاساسية للصنف  مطلوب',
        'retail_units_id.required'=>'وحدة التجزئة مطلوبة',
        'active.required'=>'   حالة تفعيل الصنف مطلوب',
        ];
    }
    
}
