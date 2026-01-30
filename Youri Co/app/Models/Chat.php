<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'staff_id',
        'message',
        'staff_message',
        'file',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
