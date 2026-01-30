<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\FirebaseService;


use DB;

class NotificationController extends Controller
{
    
    
 public function create()
{
    // Fetch only customers created by (or belonging to) the logged-in company
    $customers = Customer::where('created_by', Auth::id())->get();

    return view('companyAdmin.notifications.create', compact('customers'));
}


   
   public function store(Request $request)
{
    //  1. Validate input
    $request->validate([
        'customers' => 'required|array',
        'message' => 'required|string',
        'reminder_date' => 'nullable|date',
        'attachment' => 'nullable|file|max:2048',
    ]);

    //  2. Handle file upload
    $filePath = null;
    if ($request->hasFile('attachment')) {
        $filePath = $request->file('attachment')->store('attachments', 'public');
    }

    //  3. Get Firebase project info and access token
    $projectId = env('FIREBASE_PROJECT_ID');
    $accessToken = FirebaseService::getAccessToken();
    $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

    //  4. Loop through all customers and send notifications
    foreach ($request->customers as $customerId) {
        $customer = Customer::find($customerId);

        if (!$customer || !$customer->fcm_token) {
            Log::warning("⚠️ No FCM token for customer ID {$customerId}");
            continue;
        }

        //  5. Save notification to DB
        $notification = Notification::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $customerId,
            'title' => 'New Message from ' . Auth::user()->name,
            'message' => $request->message,
            'attachment' => $filePath,
            'reminder_date' => $request->reminder_date,
        ]);

        // 6. Build FCM v1 request body
      $body = [
    "message" => [
        "token" => $customer->fcm_token,
        "notification" => [
            "title" => "New Message from " . Auth::user()->name,
            "body" => $request->message,
        ],
        "android" => [
            "notification" => [
                "sound" => "jms_audio", // ✅ no extension, sound must exist inside Flutter project (res/raw/)
                "channel_id" => "high_importance_channel",
            ],
        ],
        "apns" => [
            "payload" => [
                "aps" => [
                    "sound" => "jms_audio.mp3", // ✅ with extension for iOS
                ],
            ],
        ],
        "data" => [
            "notification_id" => (string) $notification->id,
            "sender_id" => (string) Auth::id(),
            "receiver_id" => (string) $customerId,
            "message" => $request->message,
            "attachment" => $filePath ?? '',
            "reminder_date" => $request->reminder_date ?? '',
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "type" => "general_notification",
        ],
    ],
];


        // ✅ 7. Send FCM notification
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url, $body);

            if ($response->successful()) {
                Log::info("✅ FCM notification sent to customer ID {$customer->id}");
            } else {
                Log::error("❌ FCM Notification failed for customer {$customerId}: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("❌ FCM Notification exception: " . $e->getMessage());
        }
    }

    // ✅ 8. Done
    return redirect()->back()->with('success', 'Notifications sent successfully!');
}
   
}