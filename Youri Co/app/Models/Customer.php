<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Customer extends Model
{
    use HasFactory, HasApiTokens;
    protected $table ='customers';
    protected $guarded = [];
    
    
    
    
    
    
    
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'receiver_id');
    }
    
    
    // App\Models\Customer.php

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    
}
