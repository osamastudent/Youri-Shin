<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FrontPackagesController extends Controller
{
    private function generateUniqueReferralCode() {
        do {
            $refrel_code = rand(1000, 9999);
        } while (User::where('refrel_code', $refrel_code)->exists());

        return $refrel_code;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'contact' => ['required', 'numeric'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:password']
        ]);

        $refrel_code = $this->generateUniqueReferralCode();

        $fileName = null;
        if ($request->hasFile('logo_img')) {
            $file = $request->file('logo_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension(); 
            $file->move(public_path('uploads'), $fileName);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'contact_number' => $request->contact,
            'password' => Hash::make($request->password),
            'confirm_password' => $request->confirm_password,
            'user_type' => 2,
            'created_by' => 1,
            'logo_img' => $fileName,
            'subscription_id' => $request->subscription_id,
            'status' => 0,
            'refrel_code' => $refrel_code
        ]);

        return redirect()->back()->with('success', 'Your Request Has Been Submitted!');
    }
}
