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
=======
    public function items(){
      return $this->hasMany(Receipt_items::class);
>>>>>>> b095bf80761da70ef6e82bbfe259fa00a469a606
    }
}
