<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items_movements_categories extends Model
{
    use HasFactory;

    protected $table="items_movements_categories";
    protected $fillable=[
        'id','name'     ];
}
