<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable =
    [
    'cashier_id',
    'total',
    ];
<<<<<<< HEAD
    public function items(){
        return $this->hasMany(Receipt_items::class);
    }
=======
    public function items()
{
    return $this->hasMany(Receipt_items::class, 'recipt_id');
}
>>>>>>> 9d91f7500b2d66c4e70153b773c00b70cad73126
}
