<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'rider_id',
        'latitude',
        'longitude',
    ];
    
    
    public function order()
{
    return $this->belongsTo(Sales::class, 'order_id');
}

    
    
}
