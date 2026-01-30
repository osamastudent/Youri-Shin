<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\RiderLocationController;
use App\Http\Controllers\API\SubscriptionController;

use App\Http\Controllers\API\GuideController;



use App\Models\Staff;
use App\Models\Customer;



/*  
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ApiController::class)->group(function(){
    // CUSTOMER REGISTER
   Route::post('customer_register', 'register');
   // CUSTOMER REGISTER
   Route::post('customer_login', 'customer_login');
   Route::get('customers', 'customers');
   
   
//   STAFF LOGIN
   Route::post('staff_login', 'staff_login');
   
   //   ADD SALE
   Route::post('add_sale', 'add_sale');
   Route::get('get_sale', 'get_sale');
   Route::get('get_sale/{customer_id}', 'get_saleByID');
   Route::get('get_orders/{staff_id}', 'get_saleByStaffID');
   Route::post('status/{id}', 'updateStatus');

  //   ALL ITEMS
   Route::get('items', 'items');
   Route::get('items/{refrel_code}', 'itemsByCode');
   
   //   ALL BANNERS
   Route::get('banners/{refrel_code}', 'bannerByCode');
   
   //   ALL EXPENSES
   Route::post('add_expense', 'expense');
   Route::get('get_expense', 'get_expense');
   
   //   ALL EXPENSES CATEGORY
   Route::get('expense_category', 'category');


   // Customer Profile Update 
    Route::post('customer_update_profile/{id}', 'customer_update_profile');
   
//   Customer Chat
    Route::get('customer/chat/{id}', 'getMessages');
    Route::post('customer/chat/send', 'sendMessage');
    
   
   Route::get('/coupon', 'getCouponDetails');

   
});



Route::post('/send-notification', [NotificationController::class, 'sendNotification']);


Route::post('/rider-location', [RiderLocationController::class, 'store']);
Route::get('/get-location/{order_id}', [RiderLocationController::class, 'getLatestLocationByOrder']);


Route::post('/save-token', function (Request $request) {
    $request->validate([
        'staff_id'  => 'required|exists:staff,id',
        'fcm_token' => 'required'
    ]);

    $staff = Staff::find($request->staff_id);
    $staff->update(['fcm_token' => $request->fcm_token]);

    return response()->json(['message' => 'Token saved successfully']);
});


//Subscription Management



Route::post('/subscriptions/daily', [SubscriptionController::class, 'storeDaily']);
Route::post('/subscriptions/weekly', [SubscriptionController::class, 'storeWeekly']);
Route::post('/subscriptions/monthly', [SubscriptionController::class, 'storeMonthly']);



Route::post('/subscriptions/store', [SubscriptionController::class, 'store']);

Route::get('/user-subscriptions', [SubscriptionController::class, 'getByReferral']);
Route::get('/subscriptions/customer/{customerId}', [SubscriptionController::class, 'getByCustomer']);

Route::post('/subscriptions/update-status/{id}', [SubscriptionController::class, 'updateStatus']);


// Customer Push Notification

Route::post('/store/customer-token', function (Request $request) {
    $request->validate([
        'customer_id'  => 'required|exists:customers,id',
        'fcm_token' => 'required'
    ]);

    $customer = Customer::find($request->customer_id);
    $customer->update(['fcm_token' => $request->fcm_token]);

    return response()->json(['message' => 'Token saved successfully']);
});

//Guides
Route::get('/guides/rider', [GuideController::class, 'getRiderGuides']);
Route::get('/guides/user', [GuideController::class, 'getUserGuides']);

         











