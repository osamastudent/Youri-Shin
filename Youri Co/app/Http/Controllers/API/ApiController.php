<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Customer; 
use App\Models\CustomerChat; 
use App\Models\User; 
use App\Models\Staff; 
use App\Models\Sales; 
use App\Models\Items; 
use App\Models\Banners; 
use App\Models\Expense; 
use App\Models\Package; 
use App\Models\ExpenseCategory; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use File;


class ApiController extends Controller
{
    
    /*****************************************/
    /********MOBILE USER'S REGISTTRATION************/
    /*****************************************/
                    
    // public function register(Request $request)
    // {
    //     // Validation
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'address' => 'required',
    //         'zone_id' => 'required', 
    //         'category' => 'required', 
    //         'phone_number' => 'required',
    //         'id_card_no' => 'required',
    //         'email' => ['required', 'string', 'lowercase', 'max:255', 'unique:' . Customer::class],
    //         'password' => 'required|min:6',
    //         'confirm_password' => 'required|same:password',
    //         'refrel_code' => 'required|exists:users,refrel_code'
    //     ]);
    
    //     if ($validator->fails()) {
    //         $response = [
    //             'success' => false,
    //             'message' => $validator->errors()
    //         ];
    //         return response()->json($response, 400);
    //     }
    
    //     // Fetch the user associated with the referral code
    //     $referringUser = User::where('refrel_code', $request->refrel_code)->first();
    
    //     if (!$referringUser) {
    //         $response = [
    //             'success' => false,
    //             'message' => 'Referral code not found.'
    //         ];
    //         return response()->json($response, 400);
    //     }
    
    //     // Get the subscription details of the referring user
    //     $subscriptionId = $referringUser->subscription_id;
    //     if (!$subscriptionId) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Subscription ID not found for the referring user.'
    //         ], 400);
    //     }
    
    //     $package = Package::where('id', $subscriptionId)->first();
    //     if (!$package) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Referring user does not have a valid subscription package.'
    //         ], 400);
    //     }
    
    //     $allowedCustomer = $package->no_of_customers;
    //     if ($allowedCustomer === null) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Allowed customer number not defined in the subscription package.'
    //         ], 400);
    //     }
    
    //     $existingCustomerCount = Customer::where('created_by', $referringUser->id)->count();
    
    //     // Get all input data
    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $input['created_by'] = $referringUser->id;
        
    //     $company = $referringUser->name;
    //     // Set status based on customer limit
    //     if ($allowedCustomer !== 'Unlimited' && $existingCustomerCount >= $allowedCustomer) {
    //         $input['status'] = 0;
    //         $message = "Your request has been submitted, but now your account is deactivated. Kindly contact $company For More Info!";
    //     } else {
    //         $input['status'] = 1;
    //         $message = 'User Registered Successfully!';
    //     }
        
        
    //     // Create the user
    //     $user = Customer::create($input);
    
    //     $success['id'] = $user->id;
    //     $success['name'] = $user->name;
    
    //     $response = [
    //         'success' => true,
    //         'data' => $success,
    //         'message' => $message
    //     ];
    
    //     return response()->json($response, 200);
    // }
    public function register(Request $request)
   {
    // Validation
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'address' => 'required',
        'zone_id' => 'required', 
        'category' => 'required', 
        'phone_number' => 'required',
        'id_card_no' => 'required',
        'email' => ['required', 'string', 'lowercase', 'max:255', 'unique:' . Customer::class],
        'password' => 'required|min:6',
        'confirm_password' => 'required|same:password',
        'refrel_code' => 'required|exists:users,refrel_code',
        'profile_image' => 'required|max:2048', // Profile image validation
    ]);

    if ($validator->fails()) {
        $response = [
            'success' => false,
            'message' => $validator->errors()
        ];
        return response()->json($response, 400);
    }

    // Fetch the user associated with the referral code
    $referringUser = User::where('refrel_code', $request->refrel_code)->first();

    if (!$referringUser) {
        $response = [
            'success' => false,
            'message' => 'Referral code not found.'
        ];
        return response()->json($response, 400);
    }

    // Get the subscription details of the referring user
    $subscriptionId = $referringUser->subscription_id;
    if (!$subscriptionId) {
        return response()->json([
            'success' => false,
            'message' => 'Subscription ID not found for the referring user.'
        ], 400);
    }

    $package = Package::where('id', $subscriptionId)->first();
    if (!$package) {
        return response()->json([
            'success' => false,
            'message' => 'Referring user does not have a valid subscription package.'
        ], 400);
    }

    $allowedCustomer = $package->no_of_customers;
    if ($allowedCustomer === null) {
        return response()->json([
            'success' => false,
            'message' => 'Allowed customer number not defined in the subscription package.'
        ], 400);
    }

    $existingCustomerCount = Customer::where('created_by', $referringUser->id)->count();

    // Get all input data
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $input['created_by'] = $referringUser->id;

    // Upload profile image
    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $fileName);
        $input['profile_image'] = $fileName; 
    }

    $company = $referringUser->name;
    // Set status based on customer limit
    if ($allowedCustomer !== 'Unlimited' && $existingCustomerCount >= $allowedCustomer) {
        $input['status'] = 0;
        $message = "Your request has been submitted, but now your account is deactivated. Kindly contact $company For More Info!";
    } else {
        $input['status'] = 1;
        $message = 'User Registered Successfully!';
    }

    // Create the user
    $user = Customer::create($input);

    $success['id'] = $user->id;
    $success['name'] = $user->name;

    $response = [
        'success' => true,
        'data' => $success,
        'message' => $message
    ];

    return response()->json($response, 200);
}
    
    
    /*****************************************/
    /********CUSTOMER LOGIN************/
    /*****************************************/
    public function customer_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        
        $user = Customer::where('email', $request->email)->first();
    
        // Check if the user exists
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }
    
        if (!password_verify($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }
        
    
        $company = User::where('refrel_code', $user->refrel_code)->first();
        
    
        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company not found',
            ], 404);
        }
    
        $admin = $company->name;
        
        if ($user->status != 1) {
            return response()->json([
                'success' => false,
                'message' => "Your Account Has Been Deactivated, Kindly Contact $admin For More Info!",
            ], 403);
        }
        
        $token = $user->createToken('mobile-app-token')->plainTextToken;
        $user['company_name'] = $company->name;
        $user['company_img'] = env("APP_URL") . 'public/uploads/' . $company->logo_img; 
        $user['profile_img'] = env("APP_URL") . 'public/uploads/' . $user->profile_image;
    
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'message' => 'Customer Logged In Successfully!',
        ]);
    }
    
    public function customers()
    {
        $customers = Customer::all();
        return response()->json([
            'success' => 'true',
            'data' => $customers,
            'messsage' => 'List Of All Customers'
        ]);
    }

public function customer_update_profile(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        
        'address' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:20'],
        'password' => ['nullable', 'string', 'confirmed'],
        'profile_image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'], // Image validation
    ]);

    // Validation fail hone par response bhejna
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()
        ], 400);
    }

    // Customer find karein
    $customer = Customer::find($id);

    if (!$customer) {
        return response()->json([
            'success' => false,
            'message' => 'Customer not found'
        ], 404);
    }

    // Profile image upload
    if ($request->hasFile('profile_image')) {
        if ($customer->profile_image) {
            @unlink(public_path('uploads/' . $customer->profile_image));
        }

        $file = $request->file('profile_image');
        $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $fileName);
        $customer->profile_image = $fileName;
    }

    // Password ko sirf tab update karein jab naye password ka input aaye
    if ($request->filled('password')) {
        $customer->password = Hash::make($request->password);
    }

    // Customer update
    $customer->update([
       
        'address' => $request->address,
        'phone_number' => $request->phone_number,
        'created_by' => Auth::id(),
    ]);

    $path = env("APP_URL") . "/uploads/";
    
    $customer->profile_image = $path.$customer->profile_image;

    return response()->json([
        'success' => true,
        'message' => 'Customer profile updated successfully',
        'customer' => $customer
    ]);
}




    
    
    
    /*****************************************/
    /********STAFF LOGIN************/
    /*****************************************/
    
    public function staff_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        
        $user = Staff::join('users', 'users.id', '=', 'staff.created_by')->select('staff.*', 'users.name as company_name', 'users.logo_img as company_img', 'users.refrel_code as refrel_code' )->where('staff.email', $request->email)->first();
        
        if (!$user || !password_verify($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

       
       $token = $user->createToken('mobile-app-token')->plainTextToken;
        $user->company_img = env("APP_URL") . 'public/uploads/' . $user->company_img;  
        $user->staff_img = env("APP_URL") . 'public/uploads/' . $user->staff_img;

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'message' => 'Staff Logged In Succesfully!',
        ]);
    }
    
    public function items()
    {
            $items = Items::all();
            $items->transform(function ($item) {
            $item['item_img'] = env("APP_URL") . '/public/uploads/' . $item->item_img;
            return $item;
        });
        return response()->json([
            'message' => 'List Of All Items!',
            'data' => $items
        ]);
    }
    
    // public function itemsByCode($refrel_code)
    // {
    //     // Assuming the referral code is a unique identifier, you can use where() to fetch the item.
    //     $items = Items::where('refrel_code', $refrel_code)->get();
        
    //     // Check if the item exists
    //     if ($items->isEmpty()) {
    //         return response()->json([
    //             'message' => 'Item not found!',
    //             'data' => null
    //         ], 404);
    //     }
        
    //     // Loop through each item to prepend APP_URL to item_img
    //     $items->transform(function ($item) {
    //         $item['item_img'] = env("APP_URL") . '/public/uploads/' . $item->item_img;
    //         return $item;
    //     });
    
    //     return response()->json([
    //         'message' => 'Item details!',
    //         'data' => $items
    //     ]);
    // }
    
    public function itemsByCode($refrel_code)
{
    // Fetch items by referral code OR barcode = 1234
    $items = Items::where('refrel_code', $refrel_code)
       
        ->get();
    
    // Check if any item exists
    if ($items->isEmpty()) {
        return response()->json([
            'message' => 'Item not found!',
            'data' => null
        ], 404);
    }
    
    // Prepend APP_URL to item_img
    $items->transform(function ($item) {
        $item['item_img'] = env("APP_URL") . '/public/uploads/' . $item->item_img;
        return $item;
    });

    return response()->json([
        'message' => 'Item details!',
        'data' => $items
    ]);
}

    
    public function bannerByCode($refrel_code)
    {
        // Assuming the referral code is a unique identifier, you can use where() to fetch the item.
        $banners = Banners::where('refrel_code', $refrel_code)->get();
        
        // Check if the item exists
        if ($banners->isEmpty()) {
            return response()->json([
                'message' => 'Item not found!',
                'data' => null
            ], 404);
        }
        
        // Loop through each item to prepend APP_URL to item_img
        $banners->transform(function ($banners) {
            $banners['banner_img'] = env("APP_URL") . '/public/uploads/' . $banners->banner_img;
            return $banners;
        });
    
        return response()->json([
            'message' => 'List Of All Banner!',
            'data' => $banners
        ]);
    }


    
    
    // public function add_sale(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'customer_id' => ['required'],
    //         'item_id' => ['required'],
    //         'buying_qty' => ['required'],
    //         'unit_price' => ['required'],
    //         'buying_price' => ['required'],
    //         'payment' => ['required'],
    //     ]);
        
    //     if ($validator->fails()) {
    //         $response = [
    //             'success' => false,
    //             'message' => $validator->errors()
    //         ];
    //         return response()->json($response, 400);
    //     }
        
    //     $salesData = $request->all();
    //     $salesData['status'] = 0;
    //     $salesData['bottle_recieved'] = 0;
    //     $salesData['cash_received'] = $request->cash_received ? $request->cash_received : 0;
    //     $salesData['balance'] = $request->balance ? $request->balance : $request->total_amount;
    //     $salesData['created_at'] = Carbon::now();
    //     $salesData['updated_at'] = Carbon::now();
    //     Sales::insert($salesData);
    
    //     // Return a response (assuming you're using API)
    //     return response()->json([
    //             'message' => 'Sales added successfully',
    //             'data' => $salesData
    //         ], 200);
    // }
    



// public function add_sale(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'customer_id' => ['required'],
//         'item_id' => ['required'],
//         'buying_qty' => ['required'],            
//         'unit_price' => ['required'],
//         'buying_price' => ['required'],
//         'payment' => ['required'],
//         'payment_type' => ['required', 'in:cash,jal_card'],
//         'total_amount' => ['required', 'numeric', 'min:1'],
//         'address' => ['required'],
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'success' => false,
//             'message' => $validator->errors()
//         ], 400);
//     }

//     $salesData = $request->only([
//         'customer_id',
//         'item_id',
//         'buying_qty',
//         'unit_price',
//         'buying_price',
//         'payment',
//         'payment_type',
//         'total_amount',
//         'address',
//     ]);

//     $salesData['status'] = 0;
//     $salesData['bottle_recieved'] = 0;
//     $salesData['cash_received'] = $request->cash_received ?? 0;
//     $salesData['balance'] = $request->balance ?? $request->total_amount;
//     $salesData['created_at'] = Carbon::now();
//     $salesData['updated_at'] = Carbon::now();

//     $totalAmount = $request->total_amount;
//     $discount = 0;



//     // ✅ Add created_by (based on the customer’s associated user)
//     $customer = DB::table('customers')->where('id', $request->customer_id)->first();
//     if ($customer) {
//         $salesData['created_by'] = $customer->created_by ?? null;
//     }


//     // ✅ Handle Coupon (optional)
//     if ($request->has('code') && !empty($request->code)) {
//         $coupon = DB::table('coupons')->where('code', $request->code)->first();

//         if (!$coupon) {
//             return response()->json(['success' => false, 'message' => 'Invalid coupon code'], 400);
//         }

//         if (!$coupon->is_active) {
//             return response()->json(['success' => false, 'message' => 'This coupon is not active'], 400);
//         }

//         if ($coupon->expired_date < Carbon::now()) {
//             return response()->json(['success' => false, 'message' => 'This coupon has expired'], 400);
//         }

//         if ($coupon->used >= $coupon->quantity) {
//             return response()->json(['success' => false, 'message' => 'Coupon usage limit reached'], 400);
//         }

//         if ($coupon->minimum_amount && $totalAmount < $coupon->minimum_amount) {
//             return response()->json(['success' => false, 'message' => 'Minimum order amount not met for this coupon'], 400);
//         }

//         // Apply discount (fixed or percentage)
//         if ($coupon->type == 'percentage') {
//             $discount = ($totalAmount * $coupon->amount) / 100;
//         } else {
//             $discount = $coupon->amount;
//         }

//         $totalAmount -= $discount;
//         if ($totalAmount < 0) $totalAmount = 0;

//         // Increment usage
//         DB::table('coupons')->where('id', $coupon->id)->update([
//             'used' => $coupon->used + 1,
//             'updated_at' => Carbon::now()
//         ]);

//         $salesData['coupon_code'] = $request->code;
//     }

//     // ✅ Handle Jal Card Payment
//     if ($request->payment_type === 'jal_card') {
//         if (!$request->has('card_no')) {
//             return response()->json(['success' => false, 'message' => 'Card number is required for Jal Card payment'], 400);
//         }

//         $card = DB::table('jal_cards')->where('card_no', $request->card_no)->first();

//         if (!$card) {
//             return response()->json(['success' => false, 'message' => 'Invalid Jal Card number'], 400);
//         }

//         if ($card->amount < $totalAmount) {
//             return response()->json(['success' => false, 'message' => 'Insufficient Jal Card balance'], 400);
//         }

//         // Deduct from card & add to expense
//         DB::table('jal_cards')->where('card_no', $request->card_no)->update([
//             'amount' => $card->amount - $totalAmount,
//             'expense' => $card->expense + $totalAmount,
//             'updated_at' => Carbon::now()
//         ]);

//         $salesData['card_no'] = $request->card_no;
//     }

//     // ✅ Save Sale
//     $salesData['total_amount'] = $totalAmount; // Final amount after any discount

//     Sales::create($salesData);

//     return response()->json([
//         'success' => true,
//         'message' => 'Sale added successfully',
//         'data' => [
//             'customer_id' => $salesData['customer_id'],
//             'coupon_discount' => $discount,
//             'final_amount_paid' => $totalAmount,
//             'payment_type' => $salesData['payment_type'],
//             'coupon_code' => $salesData['coupon_code'] ?? null,
//             'card_no' => $salesData['card_no'] ?? null,
//         ]
//     ], 200);
// }





public function add_sale(Request $request)
{
    $validator = Validator::make($request->all(), [
        'customer_id' => ['required'],
        'item_id' => ['required'],
        'buying_qty' => ['required'],            
        'unit_price' => ['required'],
        'buying_price' => ['required'],
        'payment' => ['required'],
        'payment_type' => ['required', 'in:cash,jal_card'],
        'total_amount' => ['required', 'numeric', 'min:1'],
        'address' => ['required'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()
        ], 400);
    }

    $salesData = $request->only([
        'customer_id',
        'item_id',
        'buying_qty',
        'unit_price',
        'buying_price',
        'payment',
        'payment_type',
        'total_amount',
        'address',
    ]);

    $salesData['status'] = 0;
    $salesData['bottle_recieved'] = 0;
    $salesData['cash_received'] = $request->cash_received ?? 0;
    $salesData['balance'] = $request->balance ?? $request->total_amount;
    $salesData['created_at'] = Carbon::now();
    $salesData['updated_at'] = Carbon::now();

    $totalAmount = $request->total_amount;
    $discount = 0;

    // ✅ Add created_by (based on customer’s associated user)
    $customer = DB::table('customers')->where('id', $request->customer_id)->first();
    if ($customer) {
        $salesData['created_by'] = $customer->created_by ?? null;
    }

    // ✅ Handle Coupon (optional)
    if ($request->has('code') && !empty($request->code)) {
        $coupon = DB::table('coupons')->where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code'], 400);
        }

        if (!$coupon->is_active) {
            return response()->json(['success' => false, 'message' => 'This coupon is not active'], 400);
        }

        if ($coupon->expired_date < Carbon::now()) {
            return response()->json(['success' => false, 'message' => 'This coupon has expired'], 400);
        }

        if ($coupon->used >= $coupon->quantity) {
            return response()->json(['success' => false, 'message' => 'Coupon usage limit reached'], 400);
        }

        if ($coupon->minimum_amount && $totalAmount < $coupon->minimum_amount) {
            return response()->json(['success' => false, 'message' => 'Minimum order amount not met for this coupon'], 400);
        }

        // Apply discount (fixed or percentage)
        if ($coupon->type == 'percentage') {
            $discount = ($totalAmount * $coupon->amount) / 100;
        } else {
            $discount = $coupon->amount;
        }

        $totalAmount -= $discount;
        if ($totalAmount < 0) $totalAmount = 0;

        // Increment usage
        DB::table('coupons')->where('id', $coupon->id)->update([
            'used' => $coupon->used + 1,
            'updated_at' => Carbon::now()
        ]);

        $salesData['coupon_code'] = $request->code;
    }

    // ✅ Handle Jal Card Payment
    if ($request->payment_type === 'jal_card') {
        if (!$request->has('card_no')) {
            return response()->json(['success' => false, 'message' => 'Card number is required for Jal Card payment'], 400);
        }

        $card = DB::table('jal_cards')->where('card_no', $request->card_no)->first();

        if (!$card) {
            return response()->json(['success' => false, 'message' => 'Invalid Jal Card number'], 400);
        }

        if ($card->amount < $totalAmount) {
            return response()->json(['success' => false, 'message' => 'Insufficient Jal Card balance'], 400);
        }

        // Deduct from card & add to expense
        DB::table('jal_cards')->where('card_no', $request->card_no)->update([
            'amount' => $card->amount - $totalAmount,
            'expense' => $card->expense + $totalAmount,
            'updated_at' => Carbon::now()
        ]);

        $salesData['card_no'] = $request->card_no;
    }

    // ✅ NEW: Use OpenCage Data API to get latitude & longitude
    try {
        $apiKey = env('OPENCAGE_API_KEY'); // Put your key in .env like: OPENCAGE_API_KEY=your_key_here
        $response = Http::get("https://api.opencagedata.com/geocode/v1/json", [
            'q' => $request->address,
            'key' => $apiKey,
        ]);

        if ($response->successful() && isset($response['results'][0]['geometry'])) {
            $geo = $response['results'][0]['geometry'];
            $salesData['latitude'] = $geo['lat'];
            $salesData['longitude'] = $geo['lng'];
        }
    } catch (\Exception $e) {
        // fail silently if geocoding fails
        $salesData['latitude'] = null;
        $salesData['longitude'] = null;
    }

    // ✅ Save Sale
    $salesData['total_amount'] = $totalAmount; // Final amount after any discount
    Sales::create($salesData);

    return response()->json([
        'success' => true,
        'message' => 'Sale added successfully',
        'data' => [
            'customer_id' => $salesData['customer_id'],
            'coupon_discount' => $discount,
            'final_amount_paid' => $totalAmount,
            'payment_type' => $salesData['payment_type'],
            'coupon_code' => $salesData['coupon_code'] ?? null,
            'card_no' => $salesData['card_no'] ?? null,
            'latitude' => $salesData['latitude'] ?? null,
            'longitude' => $salesData['longitude'] ?? null,
        ]
    ], 200);
}



public function updateStatus(Request $request, $id)
{
    // Step 1: Validate the incoming request
    $validator = Validator::make($request->all(), [
        'status' => ['required', 'integer'], // Ensure status is required and valid
        'bottle_recieved' => ['nullable', 'integer'],
        'process_at' => ['nullable', 'date'], // Validate as a valid date format
        'dispatched_at' => ['nullable', 'date'],
        'delivered_at' => ['nullable', 'date'],
        'cash_received' => ['nullable', 'numeric'],
        'balance' => ['nullable', 'numeric'],
        'latitude' => ['nullable', 'numeric'],
        'longitude' => ['nullable', 'numeric'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors(),
        ], 400);
    }

    // Step 2: Find the order
    $order = Sales::findOrFail($id);

    // Step 3: Update the order fields
    $order->status = $request->status;
    $order->bottle_recieved = $request->bottle_recieved;
    $order->cash_received = $request->cash_received;
    $order->balance = $request->balance;
    $order->latitude = $request->latitude;
    $order->longitude = $request->longitude;

    // Update timestamps only if they are provided
    if ($request->has('process_at')) {
        $order->process_at = Carbon::parse($request->process_at);
    }
    if ($request->has('dispatched_at')) {
        $order->dispatched_at = Carbon::parse($request->dispatched_at);
    }
    if ($request->has('delivered_at')) {
        $order->delivered_at = Carbon::parse($request->delivered_at);
    }

    // Save the changes
    $order->save();

    // Step 4: Return a success response
    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully!',
        'data' => $order, // Optional: include updated order data
    ]);
}

    
    public function get_sale()
    {
        $sales = Sales::all();
        
        $salesWithItemNames = $sales->map(function ($sale) {
            $itemIds = explode(',', $sale->item_id);
            
            $items = Items::whereIn('id', $itemIds)->pluck('name')->toArray();
            
            $saleWithItemNames = clone $sale;
            
            $saleWithItemNames->item_names = $items;
            
            return $saleWithItemNames;
        });
    
        return response()->json([
            'success' => true,
            'data' => $salesWithItemNames,
            'message' => 'List Of All Orders!'
        ]);
    }



    
    public function get_saleByID($customerID)
    {
        $sales = Sales::where('customer_id', $customerID)->get();
        
        $salesWithItemNames = $sales->map(function ($sale) {
            $itemIds = explode(',', $sale->item_id);
            
            $items = Items::whereIn('id', $itemIds)->pluck('name')->toArray();
            
            $saleWithItemNames = clone $sale;
            
            $saleWithItemNames->item_names = $items;
            
            return $saleWithItemNames;
        });
    
        return response()->json([
            'success' => true,
            'data' => $salesWithItemNames,
            'message' => 'List Of All Orders!'
        ]);
    }

    
    public function get_saleByStaffID($staffID)
    {
        $sales = Sales::join('customers', 'customers.id', '=', 'sales.customer_id')->select('sales.*', 'customers.name as customer_name')->where('staff_id', $staffID)->get();
        
        $salesWithItemNames = $sales->map(function ($sale) {
            $itemIds = explode(',', $sale->item_id);
            
            $items = Items::whereIn('id', $itemIds)->pluck('name')->toArray();
            
            $saleWithItemNames = clone $sale;
            
            $saleWithItemNames->item_names = $items;
            
            return $saleWithItemNames;
        });
    
        return response()->json([
            'success' => true,
            'data' => $salesWithItemNames,
            'message' => 'List Of All Orders!'
        ]);
    }
    
    
    public function expense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'category_id' => 'required',
            'staff_id' => 'required',
            'expense_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate as an image file
            'amount' => 'required',
        ]);
    
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
    
        $input = $request->all();
    
        $fileName = null;
        if ($request->hasFile('expense_img')) {
            $file = $request->file('expense_img');
            $fileName = md5($file->getClientOriginalName()) . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('./uploads'), $fileName);
            $input['expense_img'] = $fileName; 
        }
    
        $expense = Expense::create($input);
        $expense->expense_img = env("APP_URL") . $expense->expense_img;
        $response = [ 
            'success' => true,
            'data' => $expense,
            'message' => 'Expense Added Successfully!'
        ];
    
        return response()->json($response, 200);
    }
    
public function get_expense(Request $request)
{
    // Validate referral code
    $request->validate([
        'refrel_code' => 'required|string|exists:users,refrel_code'
    ]);

    // Get the referral code from request
    $referralCode = $request->refrel_code;

    // Find the company (user) with this referral code
    $company = User::where('refrel_code', $referralCode)->first();

    if (!$company) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid referral code provided.',
            'data' => []
        ], 404);
    }

    // Fetch all expenses created by this company
    $expenses = Expense::where('created_by', $company->id)->get();

    return response()->json([
        'success' => true,
        'data' => $expenses,
        'message' => 'List of expenses for company with referral code: ' . $referralCode
    ]);
}


    
    public function category(Request $request)
    {
        
          // Validate referral code
    $request->validate([
        'refrel_code' => 'required|string|exists:users,refrel_code'
    ]);

    // Get the referral code from request
    $referralCode = $request->refrel_code;

    // Find the company (user) with this referral code
    $company = User::where('refrel_code', $referralCode)->first();

    if (!$company) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid referral code provided.',
            'data' => []
        ], 404);
    }

    // Fetch all expenses created by this company
    $expense_category = ExpenseCategory::where('created_by', $company->id)->get();

   
        
        return response()->json([
            'success' => 'true',
            'data' => $expense_category,
            'message' => 'List Of All Expense Categories!'
        ]);
    }




    
     /*****************************************/
    /********STAFF Chat************/
    /*****************************************/

    public function getMessages(Request $request, $id)
    {
        $messages = CustomerChat::where('customer_id', $id)->get();

        $messages->filter(function ($message) {
            return !is_null($message->file);
        })->each(function ($message) {
            $message->file = env('APP_URL') . $message->file;
        });

        return response()->json($messages);
    }

   public function sendMessage(Request $request)
{
    // ✅ 1. Validate incoming data
    $validator = Validator::make($request->all(), [
        'referral_code' => 'required|string',
        'customer_id' => 'required|integer|exists:customers,id',
        'customer_message' => 'required|string',
        'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors(),
        ], 400);
    }

    // ✅ 2. Find company by referral code
    $company = \App\Models\User::where('refrel_code', $request->referral_code)->first();

    if (!$company) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid referral code. Company not found.',
        ], 404);
    }

    // ✅ 3. Handle file upload (if any)
    $filePath = null;
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = md5($file->getClientOriginalName()) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $fileName);
        $filePath = '/uploads/' . $fileName;
    }

    // ✅ 4. Save message
    $message = new \App\Models\CustomerChat();
    $message->company_id = $company->id;
    $message->customer_id = $request->customer_id;
    $message->customer_message = $request->customer_message;
    $message->file = $filePath;
    $message->save();

    // ✅ 5. Return JSON response
    return response()->json([
        'success' => true,
        'message' => 'Message sent successfully.',
        'data' => [
            'id' => $message->id,
            'company_id' => $message->company_id,
            'customer_id' => $message->customer_id,
            'customer_message' => $message->customer_message,
            'file' => $filePath ? env('APP_URL') . $filePath : null,
            'created_at' => $message->created_at,
        ],
    ], 201);
}

    
    
    public function getCouponDetails(Request $request)
    {
        $code = $request->query('code'); // get ?code=XXXX from URL

        if (empty($code)) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon code is required'
            ], 400);
        }

        $coupon = DB::table('coupons')->where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ], 404);
        }

        if (!$coupon->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon is not active'
            ], 400);
        }

        if ($coupon->expired_date < Carbon::now()) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has expired'
            ], 400);
        }

        if ($coupon->used >= $coupon->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit reached'
            ], 400);
        }

        // ✅ Return coupon details
        return response()->json([
            'success' => true,
            'message' => 'Coupon fetched successfully',
            'data' => [
                'code' => $coupon->code,
                'type' => $coupon->type, // 'fixed' or 'percentage'
                'amount' => $coupon->amount,
                'minimum_amount' => $coupon->minimum_amount,
                'quantity' => $coupon->quantity,
                'used' => $coupon->used,
                'remaining_uses' => $coupon->quantity - $coupon->used,
                'expired_date' => $coupon->expired_date,
                'is_active' => $coupon->is_active,
            ]
        ]);
    }
    
    
    
    
}
































































