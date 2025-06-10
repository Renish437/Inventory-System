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


    public function provider(){
        return $this->belongsTo(Provider::class);
    }
  
    public function products(){
        return $this->hasMany(PurchaseProduct::class);
    }
//     protected static function booted()
// {
//     static::deleting(function ($purchase) {
//         $purchase->products()->delete();
//     });
// }
public function invoices(){
    return $this->hasMany(InvoiceRecord::class);
}
public function user(){
    return $this->belongsTo(User::class);
}
}
