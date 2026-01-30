<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\CustomerChat;
use App\Models\Zone;
use App\Models\User;
use App\Models\Brand;
use App\Models\Chat;
use App\Models\Staff;
use App\Models\Package;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DB;
use Hash;


class CustomerChatController extends Controller

{
    public function index()
    {
        $userId = Auth::id();
        $customers = Customer::where('created_by', $userId)->get();
        return view('companyAdmin.chats.customer_chats.index', compact('customers'));
    }

    public function chat($id)
    {
        $customers = Customer::findOrFail($id);
        $chats = DB::table('customer_chats')
            ->select('customer_chats.*', 'customers.name as customer_name', 'users.name as company_name')
            ->leftJoin('customers', 'customer_chats.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'customer_chats.company_id', '=', 'users.id')
            ->where(function ($query) use ($id) {
                $query->where('customer_chats.company_id', Auth::id())
                      ->where('customer_chats.customer_id', $id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('customer_chats.customer_id', $id)
                      ->where('customer_chats.company_id', Auth::id());
            })
            ->orderBy('customer_chats.created_at')
            ->get();

        if (request()->ajax()) {
            return response()->json(['customers' => $customers, 'customerchats' => $chats]);
        }


        return view('companyAdmin.chats.customer_chats.show', compact('customers', 'chats'));
    }
    
    public function loadMorechats(Request $request)
    {
        $oldestMessageId = $request->input('oldest_message_id');
    
        $chatsQuery = DB::table('chats')
            ->select('chats.*', 'staff.name as staff_name', 'users.name as company_name')
            ->leftJoin('staff', 'chats.staff_id', '=', 'staff.id')
            ->leftJoin('users', 'chats.company_id', '=', 'users.id')
            ->where(function ($query) use ($id) {
                $query->where('chats.company_id', Auth::id())
                      ->where('chats.staff_id', $id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('chats.staff_id', $id)
                      ->where('chats.company_id', Auth::id());
            });
    
        if ($oldestMessageId) {
            $chats = $chatsQuery->where('chats.id', '<', $oldestMessageId)->orderByDesc('chats.created_at')->limit(10)->get();
        } else {
            $chats = $chatsQuery->orderByDesc('chats.created_at')->limit(10)->get();
        }
    
    dd($chatsQuery);
    
        return response()->json(['chats' => $chats]);
    }


    // public function sendMessage(Request $request)
    // {
    //     $message = new CustomerChat();
    //     $message->company_id = Auth::id();
    //     $message->customer_id = $request->input('to_user_id');
    //     $message->message = $request->input('message');
        
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension(); 
    //         $file->move('./uploads/', $fileName);
    //         $message->file = $fileName;
    //     }
    //     $message->save();

    //     return redirect()->route('customer-chat.show', ['id' => $request->input('to_user_id')]);
    // }
    
    
    
    
    
    
    
    
    
  public function sendMessage(Request $request)
{
    // ✅ 1. Validate input
    $request->validate([
        'to_user_id' => 'required|integer|exists:customers,id',
        'message' => 'required|string',
        'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
    ]);

    // ✅ 2. Save chat message
    $message = new CustomerChat();
    $message->company_id = Auth::id();
    $message->customer_id = $request->input('to_user_id');
    $message->message = $request->input('message');

    // ✅ 3. Handle file upload
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/'), $fileName);
        $message->file = '/uploads/' . $fileName;
    }

    $message->save();

    // ✅ 4. Send FCM notification to customer
    try {
        $customer = Customer::find($request->input('to_user_id'));

        if ($customer && $customer->fcm_token) {
            $accessToken = FirebaseService::getAccessToken();
            $client = new Client();

            $projectId = env('FIREBASE_PROJECT_ID');
            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

$companyName = Auth::user()->name ?? 'Your Company';


            $body = [
                "message" => [
                    "token" => $customer->fcm_token,
                    "notification" => [
 "title" => "New Message from " . $companyName,
 "body" => $request->input('message'),
                    ],
                    "data" => [
                        "chat_id" => (string) $message->id,
                        "company_id" => (string) Auth::id(),
                        "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                        "type" => "chat_message",
                    ],
                ],
            ];

            $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $body,
            ]);

            Log::info("✅ FCM notification sent to customer ID {$customer->id}");
        } else {
            Log::warning("⚠️ No FCM token for customer ID {$request->input('to_user_id')}");
        }
    } catch (\Exception $e) {
        Log::error("❌ FCM Notification failed: " . $e->getMessage());
    }

    // ✅ 5. Redirect back
    return redirect()->route('customer-chat.show', ['id' => $request->input('to_user_id')])
                     ->with('success', 'Message sent and notification delivered.');
}


    
    public function create()
    {
    
        return view('companyAdmin.Brand.create');
    } 
  
    public function store(Request $request)
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'brand_image' => ['required', 'image', 'max:2048'],
                 
        ]);
        
        $fileName = null;
        if ($request->hasFile('brand_image')) {
            $file = $request->file('brand_image');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            // $file->move('../uploads', $fileName);
            $file->move(public_path('./uploads'), $fileName);

        }
        Brand::create([
            'name' => $request->name,
            'brand_image' => $fileName,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-brand.index')->with('success', 'Brand Added Successfully!');
    }
    
    public function show($id)
    {  
        $brand = Brand::find($id);
       
        return view('companyAdmin.Brand.show', compact('brand'));
    }
    public function edit($id)
    {  
        $brand = Brand::find($id);
       
        return view('companyAdmin.Brand.edit', compact('brand'));
    }
    
    
    
    public function update(Request $request, $id) 
    {  
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'brand_image' => ['required', 'image', 'max:2048'],
                 
        ]);
        
        $fileName = null;
        if ($request->hasFile('brand_image')) {
            $file = $request->file('brand_image');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move('./uploads', $fileName);
        }
        $brand = Brand::find($id);
        $brand->update([
            'name' => $request->name,
            'brand_image'=>$fileName,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-brand.index')->with('success', 'Brand Updated Successfully!');

       
    }
    
      
  
    
    public function delete($id)
    {
        $brand = Brand::findOrFail($id); 
        $brand->delete();
        return redirect()->route('company-brand.index')->with('success', 'Brand Deleted Successfully!');
    }
}
