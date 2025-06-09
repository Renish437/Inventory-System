<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
         protected $casts =[
        'data' => 'array'
    ];
  protected $guarded = [];
      public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseProduct::class);
    }
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
