<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemcardRequestUpdate extends FormRequest
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
         'items_categories_id'=>'required',
        // 'price'=>'required',
         'item_type'=>'required',
        //  'nos_gomla_price'=>'required',
        //  'gomla_price'=>'required',
         //'cost_price'=>'required',
         //'expired'=>'required_if:item_type,2',

    
         'active'=>'required',

        ];
    }

    public function messages()
    {
        return [
        'name.required'=>'اسم الصنف مطلوب',
        'items_categories_id.required'=>'فئة الصنف مطلوب',
        'item_type.required'=>'  نوع الصنف مطلوب',
        //'expired.required_if'=>'  تاريخ الانتهاء مطلوب',
       // 'price.required'=>'  سعر الوحدة الرئيسية مطلوب',
        //'nos_gomla_price.required'=>'  سعر النص جملة لوحدة الاب مطلوب',
        //'gomla_price.required'=>'سعر الجملة لوحده الاب مطلوب  ',
        //'cost_price.required'=>'  تكلفة الشراء لوحدة الرئيسية مطلوب',
  
        'active.required'=>'   حالة تفعيل الصنف مطلوب',

        ];
    }
    
}
