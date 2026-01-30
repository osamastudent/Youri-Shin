<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class ProfileController extends Controller
{
    public function index($id)
    {  
        $user = User::findOrFail($id); 
        return view('companyAdmin.profile.index', compact('user')); 
    }
}
