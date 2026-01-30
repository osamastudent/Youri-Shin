<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiderLocation;
use App\Models\Sales;
use Illuminate\Support\Facades\Validator;

class RiderLocationController extends Controller
{
 public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'order_id' => 'required|exists:sales,id',
        'rider_id' => 'required|exists:staff,id',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors(),
        ], 400);
    }

    // ✅ Check if order is still active (not delivered)
    $order = Sales::find($request->order_id);

    if ($order->status === 'delivered') {
        return response()->json([
            'success' => false,
            'message' => 'This order has already been delivered. Location update not allowed.',
        ], 403);
    }

    // ✅ Store/Update location for each order separately
    $location = RiderLocation::updateOrCreate(
        [
            'order_id' => $request->order_id,
            'rider_id' => $request->rider_id,
        ],
        [
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]
    );

    return response()->json([
        'success' => true,
        'message' => 'Rider location stored/updated successfully!',
        'data' => $location,
    ]);
}



public function getLatestLocationByOrder($order_id)
{
    // Step 1: Get latest location from RiderLocation
    $location = RiderLocation::where('order_id', $order_id)
        ->latest('updated_at')
        ->first();

    if (!$location) {
        return response()->json([
            'success' => false,
            'message' => 'No location data found for this order.',
        ], 404);
    }

    // Step 2: Get address from Sales table
    $order = Sales::select('id', 'address')->where('id', $order_id)->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Order not found in Sales table.',
        ], 404);
    }

    // Step 3: Return both location + address
    return response()->json([
        'success' => true,
        'message' => 'Latest rider location retrieved successfully.',
        'data' => [
            'order_id' => $order->id,
            'address' => $order->address,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'updated_at' => $location->updated_at,
        ],
    ]);
}


}
