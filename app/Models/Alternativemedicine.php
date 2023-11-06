<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternativemedicine extends Model
{
    use HasFactory;
    protected $table="alternativemedicine";
    protected $fillable=[
        'name','alternative_M_ID','created_at','updated_at','added_by','updated_by','deleted_at','com_code','date','active' 
        ];
}
