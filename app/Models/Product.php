<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
