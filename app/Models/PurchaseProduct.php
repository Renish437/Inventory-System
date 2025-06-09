<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    //
    protected $casts =[
        'data' => 'array'
    ];
  protected $guarded = [];
   public function product(){
       return $this->belongsTo(Product::class);
   }
   public function purchase(){
       return $this->belongsTo(Purchase::class);
   }
}
