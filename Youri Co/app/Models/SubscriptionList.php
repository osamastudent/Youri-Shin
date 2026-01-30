<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubscriptionList extends Model
{
    use HasFactory;

    protected $table = 'subscriptions_lists';

    protected $fillable = [
        'item_id',
        'customer_id',
        'buying_quantity',
        'frequency',
        'time_start',
        'time_end',
        'day_of_week',
        'day_of_month',
        'address',
        'notes',
        'status',
    ];

    /**
     * Relationship: Subscription belongs to an Item
     */
    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    /**
     * Relationship: Subscription belongs to a Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function company()
{
    return $this->belongsTo(\App\Models\User::class, 'company_id');
}


    /**
     * Accessor to get formatted timing range
     */
    public function getTimeRangeAttribute()
    {
        if ($this->time_start && $this->time_end) {
            return $this->time_start . ' - ' . $this->time_end;
        }
        return null;
    }

    /**
     * Scope: Filter by active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Filter by frequency type (daily, weekly, monthly)
     */
    public function scopeFrequency($query, $type)
    {
        return $query->where('frequency', $type);
    }
    
      // 🔹 Add saving event check
    protected static function booted()
    {
        static::updating(function ($subscription) {
            // Get the related subscription_data
            $subscriptionData = \App\Models\SubscriptionData::where('frequency', $subscription->frequency)->first();

            // If subscription_data is inactive, block reactivation
            if ($subscriptionData && $subscriptionData->status === 'inactive' && $subscription->status === 'active') {
                throw new \Exception("You cannot activate this subscription because the {$subscription->frequency} plan is currently inactive.");
            }
        });
    }
}
