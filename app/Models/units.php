<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class units extends Model
{
    use HasFactory;
    protected $table="units";
    protected $fillable=[
        'name','is_main','created_at','updated_at','added_by','updated_by','com_code','date','active' 
        ];
}
