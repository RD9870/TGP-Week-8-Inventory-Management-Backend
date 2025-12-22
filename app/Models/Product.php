<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =
    [
    'code',
    'name',
    'category_id',
    'price',
    'manufacture_id',
    'import_company_id',
    'image',
    ];

    public function stock(){
        return $this->hasMany(Stock::class);
    }

public function subCategory(){
                return $this->belongsTo(Subcategory::class);
    }

}
