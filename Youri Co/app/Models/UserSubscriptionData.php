<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionData extends Model
{
    protected $table = 'user_subscription_data';

    protected $fillable = ['user_id', 'subscription_data_id', 'status'];

    public function subscriptionData()
    {
        return $this->belongsTo(SubscriptionData::class, 'subscription_data_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
      // 🔹 Prevent reactivation if main subscription_data is inactive
    protected static function booted()
    {
        static::updating(function ($userSub) {
            $subscriptionData = $userSub->subscriptionData;
            if ($subscriptionData && $subscriptionData->status === 'inactive' && $userSub->status === 'active') {
                throw new \Exception("Cannot activate. The {$subscriptionData->frequency} subscription type is inactive. Only admin can reactivate it.");
            }
        });
    }
}
