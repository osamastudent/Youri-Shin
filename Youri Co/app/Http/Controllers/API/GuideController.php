<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guide;
use Illuminate\Support\Facades\Validator;

class GuideController extends Controller
{
    // Fetch all guides for role_type = 'rider'
    public function getRiderGuides()
    {
        $guides = Guide::where('role_type', 'rider')->get();

        return response()->json([
            'status' => 'success',
            'role_type' => 'rider',
            'count' => $guides->count(),
            'data' => $guides
        ]);
    }

    // Fetch all guides for role_type = 'user'
    public function getUserGuides()
    {
        $guides = Guide::where('role_type', 'user')->get();

        return response()->json([
            'status' => 'success',
            'role_type' => 'user',
            'count' => $guides->count(),
            'data' => $guides
        ]);
    }
}