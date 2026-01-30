<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    
public function subscriptionData()
{
    return $this->belongsToMany(SubscriptionData::class, 'user_subscription_data')
                ->withPivot('status')
                ->withTimestamps();
}

public function userSubscriptions()
{
    return $this->hasMany(\App\Models\UserSubscriptionData::class, 'user_id');
}

public function sentNotifications()
{
    return $this->hasMany(Notification::class, 'sender_id');
}



}
