<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt_items extends Model
{
    protected $fillable =
    [
    'receipt_id',
    'code',
    'quantity',
    'item_total',
    ];

    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }
}
