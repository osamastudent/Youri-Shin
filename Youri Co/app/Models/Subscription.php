<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'frequency',
        'status',
    ];

    /**
     * Relationship: Subscription belongs to a Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Scope: Get subscriptions by company
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope: Only active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
