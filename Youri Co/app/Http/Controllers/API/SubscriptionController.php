<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionList;
use App\Models\User;
use App\Models\Customer;


use App\Models\UserSubscriptionData;

use Validator;

class SubscriptionController extends Controller
{
    
   public function storeDaily(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'item_id' => 'required|exists:items,id',
            'buying_quantity' => 'required|integer|min:1',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string',
         ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $subscription = SubscriptionList::create([
            'customer_id' => $request->customer_id,
            'item_id' => $request->item_id,
            'buying_quantity' => $request->buying_quantity,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'address' => $request->address,
            'notes' => $request->notes,
            'frequency' => 'daily',
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Daily subscription created successfully.',
            'data' => $subscription,
        ], 201);
    }

 public function storeWeekly(Request $request)
{
    $validator = Validator::make($request->all(), [
        'customer_id' => 'required|exists:customers,id',
        'item_id' => 'required|exists:items,id',
        'buying_quantity' => 'required|integer|min:1',
        'day_of_week' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        'address' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'time_start' => 'required|date_format:H:i',
        'time_end' => 'required|date_format:H:i|after:time_start',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    $subscription = SubscriptionList::create([
        'customer_id' => $request->customer_id,
        'item_id' => $request->item_id,
        'buying_quantity' => $request->buying_quantity,
        'day_of_week' => strtolower($request->day_of_week),
        'time_start' => $request->time_start,
        'time_end' => $request->time_end,
        'frequency' => 'weekly',
        'address' => $request->address,
        'notes' => $request->notes,
        'status' => 'active',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Weekly subscription created successfully.',
        'data' => $subscription,
    ], 201);

}


    public function storeMonthly(Request $request)
{
    $validator = Validator::make($request->all(), [
        'customer_id' => 'required|exists:customers,id',
        'item_id' => 'required|exists:items,id',
        'buying_quantity' => 'required|integer|min:1',
        'day_of_month' => 'required|integer|min:1|max:31',
        'address' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'time_start' => 'required|date_format:H:i',
        'time_end' => 'required|date_format:H:i|after:time_start',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    $subscription = SubscriptionList::create([
        'customer_id' => $request->customer_id,
        'item_id' => $request->item_id,
        'buying_quantity' => $request->buying_quantity,
        'day_of_month' => $request->day_of_month,
        'time_start' => $request->time_start,
        'time_end' => $request->time_end,
        'address' => $request->address,
        'notes' => $request->notes,
        'frequency' => 'monthly',
        'status' => 'active',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Monthly subscription created successfully.',
        'data' => $subscription,
    ], 201);
}







    /**
     * GET /api/user-subscriptions?referral_code=XYZ123
     */
 public function getByReferral(Request $request)
{
    $referralCode = $request->query('referral_code');

    // 1 Validate referral code
    if (!$referralCode) {
        return response()->json([
            'success' => false,
            'message' => 'Referral code is required.',
        ], 400);
    }

    // 2 Find company by referral code
    $company = User::where('refrel_code', $referralCode)->first();

    if (!$company) {
        return response()->json([
            'success' => false,
            'message' => 'No company found for this referral code.',
        ], 404);
    }

    // 3 Fetch subscriptions only for this company
    $subscriptions = UserSubscriptionData::where('user_id', $company->id)
        ->get(['id', 'user_id', 'subscription_data_id', 'status']);

    // 4 Handle no data
    if ($subscriptions->isEmpty()) {
        return response()->json([
            'success' => true,
            'message' => 'No subscriptions found for this company.',
            'subscriptions' => [],
        ], 200);
    }

    // 5 Return only the desired fields
    return response()->json([
        'success' => true,
        'subscriptions' => $subscriptions,
    ], 200);
}







public function getByCustomer(Request $request, $customerId)
{
    // 1. Validate customer existence
    $customer = Customer::find($customerId);

    if (!$customer) {
        return response()->json([
            'success' => false,
            'message' => 'Customer not found.',
        ], 404);
    }

    // 2. Fetch subscriptions for this customer
    $subscriptions = SubscriptionList::where('customer_id', $customerId)
       ->with([
            'item:id,name', // include item info
           
        ])
        ->orderBy('created_at', 'desc')
        ->get();

    // 3. Handle no data case
    if ($subscriptions->isEmpty()) {
        return response()->json([
            'success' => true,
            'message' => 'No subscriptions found for this customer.',
            'data' => [],
        ], 200);
    }

    // 4. Return formatted data
    return response()->json([
        'success' => true,
      
        'subscriptions' => $subscriptions,
    ], 200);
}


public function updateStatus(Request $request, $id)
{
    // Validate the incoming status field
    $validator = Validator::make($request->all(), [
        'status' => 'required|in:active,inactive',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Find subscription by ID
    $subscription = SubscriptionList::find($id);

    if (!$subscription) {
        return response()->json([
            'success' => false,
            'message' => 'Subscription not found.',
        ], 404);
    }

    //Business rule: if parent frequency (from subscription_data) is inactive, disallow activation
    $subscriptionData = \App\Models\SubscriptionData::where('frequency', $subscription->frequency)->first();

    if ($subscriptionData && $subscriptionData->status === 'inactive' && $request->status === 'active') {
        return response()->json([
            'success' => false,
            'message' => 'Cannot activate this subscription while its frequency is inactive in Subscription Data.',
        ], 403);
    }

    // Update status 
    $subscription->status = $request->status;
    $subscription->save();

    return response()->json([
        'success' => true,
        'message' => 'Subscription status updated successfully.',
        'data' => $subscription,
    ], 200);
}


}

    

   



