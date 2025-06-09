<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
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
}
