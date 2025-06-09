<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
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
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
