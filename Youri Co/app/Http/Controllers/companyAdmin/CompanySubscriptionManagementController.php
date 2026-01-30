<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSubscriptionData;
use App\Models\SubscriptionList;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

use App\Models\Items;

use Auth;

class CompanySubscriptionManagementController extends Controller
{
    
  public function SubscriptionData()
{
     $userId = Auth::id(); // current logged-in user ID
     
      // 1️⃣ Fetch only the subscriptions that belong to this company
    $subscriptions = \App\Models\UserSubscriptionData::where('user_id', $userId)->get();

    
    // Get all subscription records (daily, weekly, monthly)


    return view('companyAdmin.subscriptions.subscription_data', compact('subscriptions'));
}









public function toggleStatus($id)
{
    $subscription = \App\Models\UserSubscriptionData::findOrFail($id);

    // Toggle status
    $subscription->status = $subscription->status === 'active' ? 'inactive' : 'active';
    $subscription->save();

    return redirect()->back()->with('success', 'Subscription status updated successfully!');
}


    public function index()
    {
        $companies = User::where('user_type', 2)
            ->with(['userSubscriptions.subscriptionData' => function ($q) {
                $q->orderByRaw("FIELD(frequency, 'daily','weekly','monthly')");
            }])
            ->orderBy('name')
            ->get();

        return view('companyAdmin.subscriptions.index', compact('companies'));
    }

    // Regular form submission - redirects back with message
    public function ajaxToggle(Request $request, $id)
    {
        try {
            $userSub = UserSubscriptionData::with(['user', 'subscriptionData'])->findOrFail($id);

            $userSub->status = $userSub->status === 'active' ? 'inactive' : 'active';
            $userSub->save();

            $message = ucfirst($userSub->subscriptionData->frequency ?? 'Subscription') . 
                      ' updated to ' . $userSub->status . ' for ' . ($userSub->user->name ?? 'Company');

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update subscription: ' . $e->getMessage());
        }
    }
    
    
    
   public function subscriptionList()
{
    $subscriptions = SubscriptionList::with(['customer', 'item'])
        ->whereHas('customer', function ($query) {
            $query->where('created_by', Auth::id()); // filter by logged-in company admin
        })
        ->get();

    return view('companyAdmin.subscriptions.list', compact('subscriptions'));
}





/**
     * Show create form
     */
    public function create()
    {
        return view('companyAdmin.subscriptions.create', [
            'customers' => Customer::all(),
            'items' => Items::all(),
        ]);
    }

    /**
     * Store subscription (daily / weekly / monthly)
     */
    public function store(Request $request)
    {
        $rules = [
            'customer_id' => 'required|exists:customers,id',
            'item_id' => 'required|exists:items,id',
            'buying_quantity' => 'required|integer|min:1',
            'frequency' => 'required|in:daily,weekly,monthly',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
        ];

        // conditional validation
        if ($request->frequency === 'weekly') {
            $rules['day_of_week'] = 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday';
        }

        if ($request->frequency === 'monthly') {
            $rules['day_of_month'] = 'required|integer|min:1|max:31';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        SubscriptionList::create([
            'customer_id' => $request->customer_id,
            'item_id' => $request->item_id,
            'buying_quantity' => $request->buying_quantity,
            'frequency' => $request->frequency,
            'day_of_week' => $request->frequency === 'weekly' ? $request->day_of_week : null,
            'day_of_month' => $request->frequency === 'monthly' ? $request->day_of_month : null,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'address' => $request->address,
            'notes' => $request->notes,
            'status' => 'active',
        ]);

        return redirect()->back()
            
            ->with('success', 'Subscription created successfully');
    }

}