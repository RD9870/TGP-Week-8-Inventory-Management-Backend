<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
      protected $fillable =
    [
    'code',
    'quantity',
    'cost_price',
    'minimum',
    'expiration_date',
    'isStockLow',
    'isProductExpired',
    ];
}
