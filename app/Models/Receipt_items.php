<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt_items extends Model
{
    protected $fillable =
    [
    'receipt_id',
    'product_id',
    'quantity',
    'item_total',
    ];

    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }
}


// <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Receipt_items extends Model
// {
//     protected $fillable =
//     [
//     'receipt_id',
//     'product_id',
//     'quantity',
//     'item_total',
//     ];

//     public function receipt(){
//         return $this->belongsTo(Receipt::class);
//     }
// <<<<<<< HEAD
// =======

// >>>>>>> b095bf80761da70ef6e82bbfe259fa00a469a606
// }

