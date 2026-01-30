<?php

namespace App\Http\Controllers\companyAdmin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\Items;
use Illuminate\Support\Facades\Log;
use Auth;

class BottlesController extends Controller
{
        public function index()
    {
        $customers = Customer::where('created_by', Auth::user()->id)->get();
        return view('companyAdmin.reports.bottles', compact('customers'));
    }
    
//   public function fetchBottles(Request $request)
//     {
//         $customerID = $request->input('customer_id');
//         $orders = Sales::join('customers', 'customers.id', '=', 'sales.customer_id')
//             ->select(
//                 'sales.*', 'customers.name as customer', 'customers.opening_stock as opening_stock'
//             )
//             ->where('customer_id', $customerID)->where('balance', '!=', 0)
//             ->get();
    
//         return response()->json(['orders' => $orders]);
//     }


public function fetchBottles(Request $request)
{
    try {
        $customerID = $request->input('customer_id');
        $companyId = auth()->user()->refrel_code; // Get company reference code from logged-in user
        
        Log::info('Fetching bottles for customer ID:', [
            'customer_id' => $customerID, 
            'company_refrel_code' => $companyId
        ]);

        // Find the "19 Litre Water Bottle" item for this specific company
        $bottleItem = \App\Models\Items::where('name', '19 Litre Water Bottle')
            ->where('refrel_code', $companyId) // Match company reference code
            ->first();

        if (!$bottleItem) {
            Log::warning('19 Litre Water Bottle not found for company:', ['company_refrel_code' => $companyId]);
            return response()->json([
                'message' => '19 Litre Water Bottle item not found for your company.'
            ], 404);
        }

        Log::info('Bottle item found for company:', [
            'bottle_id' => $bottleItem->id, 
            'bottle_name' => $bottleItem->name,
            'company_refrel_code' => $bottleItem->refrel_code
        ]);

        // Get all sales for this customer
        $sales = \App\Models\Sales::join('customers', 'customers.id', '=', 'sales.customer_id')
            ->select(
                'sales.*',
                'customers.name as customer',
                'customers.opening_stock as opening_stock'
            )
            ->where('sales.customer_id', $customerID)
            ->get();

        Log::info('Raw sales data count:', ['count' => $sales->count()]);

        $orders = $sales->map(function ($order) use ($bottleItem) {
            Log::info('Processing order:', [
                'order_id' => $order->id, 
                'item_id' => $order->item_id, 
                'buying_qty' => $order->buying_qty
            ]);
            
            // Check if item_id and buying_qty are not empty
            if (empty($order->item_id) || empty($order->buying_qty)) {
                Log::warning('Empty item_id or buying_qty', ['order_id' => $order->id]);
                return null;
            }

            // Split the comma-separated values
            $itemIds = explode(',', $order->item_id);
            $quantities = explode(',', $order->buying_qty);
            
            // Convert item IDs to integers for proper comparison
            $itemIds = array_map('intval', $itemIds);
            
            Log::info('Looking for bottle in order:', [
                'order_id' => $order->id,
                'available_items' => $itemIds,
                'looking_for_bottle_id' => $bottleItem->id
            ]);
            
            $bottleIndex = array_search($bottleItem->id, $itemIds);
            
            if ($bottleIndex === false) {
                Log::info('No water bottle found in this order', ['order_id' => $order->id]);
                return null; // No water bottle in this order
            }

            Log::info('Bottle found at index:', ['index' => $bottleIndex]);
            
            // Get the corresponding quantity
            $bottlesSent = $quantities[$bottleIndex];
            
            Log::info('Bottle data extracted:', [
                'order_id' => $order->id,
                'bottles_sent' => $bottlesSent,
                'bottle_received' => $order->bottle_recieved,
                'total_amount' => $order->total_amount,
                'cash_received' => $order->cash_received,
                'balance' => $order->balance
            ]);
            
            // Return the order data
            return [
                'id' => $order->id,
                'customer_id' => $order->customer_id,
                'customer' => $order->customer,
                'opening_stock' => $order->opening_stock,
                'item_name' => $bottleItem->name,
                'bottle_sent' => (int)$bottlesSent,
                'bottle_recieved' => $order->bottle_recieved ?? 0,
                'total_amount' => $order->total_amount ?? 0,
                'cash_received' => $order->cash_received ?? 0,
                'balance' => $order->balance ?? 0,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at
            ];
        })
        ->filter()
        ->values();

        Log::info('Final processed orders count:', ['count' => $orders->count()]);

        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'No orders found containing "19 Litre Water Bottle" for this customer.'
            ], 404);
        }

        return response()->json(['orders' => $orders]);

    } catch (\Throwable $e) {
        Log::error('Error fetching bottles:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
    }
}



}
