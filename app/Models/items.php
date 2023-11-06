<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    use HasFactory;
    protected $table="items";
    protected $fillable=[ 
        'item_type','name','name1','alternative_medicine_id','items_categories_id','retail_units','unit_id',
        'retail_unit_quntToParent','created_at','updated_at','added_by','updated_by','com_code',
        'active','date','item_code','barcode','price','gomla_price','price_retail','cost_price','cost_price_retail',
        'QUENTITY','QUENTITY_Retail','QUENTITY_all_Retails','photo','retail_units_id',
        'All_QUENTITY','ReasonForUsing','Company_ID','expired'
        ];



}
