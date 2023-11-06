<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class purchasesRequest extends FormRequest
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
         'suuplier_code'=>'required',
         'pill_type'=>'required',
         'order_date'=>'required',
         //'store_id'=>'required'
         //'deliverd_quantity',
         // 'unit_price',
        //    'total_price', 
        //    'producion_date',
        //     'expire_date', 
        //     'item_card_type'
        ];
    }

    public function messages()
    {
        return [
        'suuplier_code.required'=>'اسم  المورد',
        'pill_type.required'=>'نوع الفاتورة مطلوب',
        'order_date.required'=>'تاريخ الفاتورة مطلوب',
       // 'store_id.required'=>' المخزن المستلم للفاتورة مطلوب',
       //'deliverd_quantity.required'=>'  مطلوب الكمية',
       //'unit_price.required'=>'  مطلوب السعر',
    //    'unit_price.required'=>'  مطلوب السعر',
    //    'unit_price.required'=>'  مطلوب السعر',
       



        ];
    }
}
