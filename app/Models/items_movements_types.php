<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items_movements_types extends Model
{
    use HasFactory;
    protected $table="items_movements_types";
    protected $fillable=[
        'id','type'     ];
}
