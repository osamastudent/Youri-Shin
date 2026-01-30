<?php

namespace App\Http\Controllers\companyAdmin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Sales;
use Auth;

class DuePaymentController extends Controller
{
    public function index()
    {
        $customers = Customer::where('created_by', Auth::user()->id)->get();
        return view('companyAdmin.reports.due-payment', compact('customers'));
    }
    
   public function fetchPayment(Request $request)
{
    // Validate the incoming request to ensure 'customer_id' is provided
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
    ]);

    // Fetch the customer ID from the request
    $customerID = $request->input('customer_id');

    // Retrieve the orders associated with the customer where the balance is not zero
    $orders = Sales::join('customers', 'customers.id', '=', 'sales.customer_id')
        ->select(
            'sales.*', 
            'customers.name as customer'
        )
        ->where('sales.customer_id', $customerID)
        ->where('sales.balance', '!=', 0)
        ->get();

    // Check if any orders exist
    if ($orders->isEmpty()) {
        return response()->json([
            'message' => 'No due payments found for the selected customer.',
            'orders' => []
        ], 404);
    }

    // Return the response as JSON
    return response()->json([
        'message' => 'Orders fetched successfully.',
        'orders' => $orders
    ], 200);
}



}
