<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_invoices extends Model
{
    use HasFactory;
    protected $table="sales_invoices";
    protected $fillable=[
        'sales_matrial_types', 'auto_serial', 'invoice_date', 'customer_code', 
        'is_approved', 'com_code', 'notes', 'discount_type', 'discount_percent',
         'discount_value', 'total_cost_items', 
          'total_cost', 'account_number', 'money_for_account', 'pill_type', 'what_paid', 'what_remain',
           'treasuries_transactions_id', 'customer_balance_befor', 'customer_balance_after', 'added_by',
  'created_at', 'updated_at', 'updated_by', 'approved_by','is_has_customer','delegate_code','date',
  'sales_item_type','delegate_commission_percent','delegate_commission_value','delegate_commission_percent_type'      ];
}
