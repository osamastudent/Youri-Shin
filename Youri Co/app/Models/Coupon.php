<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable =[
        "code", "customer_id", "user_id", "type", "amount", "minimum_amount", "quantity", "used", "expired_date", "is_active"
    ];
} 