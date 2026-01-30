<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use GuzzleHttp\Client;
use App\Models\Staff;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
        ]);

        $staff = Staff::find($request->staff_id);

        if (!$staff->fcm_token) {
            return response()->json([
                'status' => 'error',
                'message' => 'No FCM token found for this staff'
            ], 400);
        }

        $accessToken = FirebaseService::getAccessToken();
        $client = new Client();

        $projectId = env('FIREBASE_PROJECT_ID');
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $body = [
            "message" => [
                "token" => $staff->fcm_token,
                "notification" => [
                    "title" => "Order Assigned",
                    "body"  => "Order assigned to the rider",
                ],
                "data" => [
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "extra_info"   => "any_custom_data",
                ]
            ]
        ];

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ],
            'json' => $body,
        ]);

        return response()->json([
            'status' => 'success',
            'response' => json_decode($response->getBody(), true),
        ]);
    }
}
