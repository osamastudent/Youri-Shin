<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\SubscriptionList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class GuideController extends Controller
{
   public function index()
{
    $guides = Guide::where('role_type', 'company_admin')->get(); 
    return view('admin.guides.index', compact('guides'));
}


 public function staff_guide()
{
    $guides = Guide::where('role_type', 'rider')->get(); 
    return view('admin.guides.staff_guide', compact('guides'));
}
   

 public function customer_guide()
{
    $guides = Guide::where('role_type', 'user')->get(); 
    return view('admin.guides.user_guide', compact('guides'));
}
             





    public function create()
    {
        return view('admin.guides.create');
    }

 
 public function store(Request $request)
{
    $request->validate([
        'video' => 'required|url',
        'role_type' => 'required|string',
    ]);

    // Updated regex to support YouTube Shorts, embed, watch, and short URLs
    preg_match(
        '/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|shorts\/))([a-zA-Z0-9_-]{11})/',
        $request->video,
        $matches
    );

    $videoId = $matches[1] ?? null;

    if (!$videoId) {
        return back()->withErrors(['video' => 'Invalid YouTube link. Please provide a valid video or Shorts URL.']);
    }

    // Fetch video details from YouTube Data API
    $apiKey = env('YOUTUBE_API_KEY');
    $response = @file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=$videoId&key=$apiKey");
    $data = json_decode($response, true);

    if (empty($data['items'])) {
        return back()->withErrors(['video' => 'Could not fetch video details. Please check your API key or video link.']);
    }

    $snippet = $data['items'][0]['snippet'];
    $title = $snippet['title'];
    $description = $snippet['description'];
    $thumbnail = $snippet['thumbnails']['high']['url']
                 ?? $snippet['thumbnails']['default']['url']
                 ?? null;

    // Save in database
    Guide::create([
        'title' => $title,
        'description' => $description,
        'image' => $thumbnail,
        'video' => "https://www.youtube.com/watch?v=$videoId", // normalized link
        'role_type' => $request->role_type,
    ]);

    return redirect()->route('admin.guides.index')->with('success', 'Guide added successfully!');
}


    

    public function update(Request $request, Guide $guide)
    {
        $request->validate([
            'video_link' => 'required|url',
            'role' => 'required|string',
        ]);

        $guide->update($request->only('video_link', 'role'));
        return redirect()->route('admin.guides.index')->with('success', 'Guide updated successfully!');
    }

    public function destroy(Guide $guide)
    {
        $guide->delete();
        return back()->with('success', 'Guide deleted successfully!');
    }
}