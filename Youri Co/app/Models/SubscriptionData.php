<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionData extends Model
{
    protected $table = 'subscription_data';

    protected $fillable = ['frequency', 'status'];

    public function users()
{
    return $this->belongsToMany(User::class, 'user_subscription_data')
                ->withPivot('status')
                ->withTimestamps();
}


public function company()
{
    return $this->belongsTo(\App\Models\User::class, 'company_id');
}


// 👇 When status changes to inactive → sync all related data
    protected static function booted()
    {
        static::updated(function ($subscriptionData) {
            // Only trigger if status changed to inactive
            if ($subscriptionData->isDirty('status') && $subscriptionData->status === 'inactive') {
                // 1️⃣ Update related user_subscription_data
                \App\Models\UserSubscriptionData::where('subscription_data_id', $subscriptionData->id)
                    ->update(['status' => 'inactive']);

                // 2️⃣ Update related subscriptions_lists (by frequency)
                \App\Models\SubscriptionList::where('frequency', $subscriptionData->frequency)
                    ->update(['status' => 'inactive']);
            }
        });
    }






}

