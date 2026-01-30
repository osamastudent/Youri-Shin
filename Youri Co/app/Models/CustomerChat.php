<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'customer_id',
        'message',
        'sender_type',
        'file',
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
