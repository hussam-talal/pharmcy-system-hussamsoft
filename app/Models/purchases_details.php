<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchases_details extends Model
{
    use HasFactory;
    protected $table="purchase_details";
    protected $fillable=[
        'purchases_auto_serial', 'order_type', 'com_code', 'deliverd_quantity',
         'unit_id', 'unit_price', 'ismainunit','total_price', 'order_date', 'added_by',
          'created_at', 'updated_by', 'updated_at', 'item_code', 'batch_auto_serial',
          'production_date','expire_date','item_card_type','approved_by','purchases_id'
    ];
}
