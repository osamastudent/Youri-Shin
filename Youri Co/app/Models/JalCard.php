<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JalCard extends Model
{
     protected $fillable =[
        "card_no", "amount", "expense", "customer_id", "user_id", "expired_date", "created_by", "is_active"
    ];
    
    
    protected $casts = [
    'expired_date' => 'date',
];



   public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }




     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    

}
