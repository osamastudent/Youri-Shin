<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;  // Import the Customer model
use App\Models\Staff;  // Import the Customer model
use Illuminate\Http\Request;

class DeactivateUserController extends Controller
{
    public function index()
    {
        return view('admin.deactivate');
    }
    
   public function deactivateUser(Request $request)
{
    // Validate input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Check if the customer exists by email
    $customer = Customer::where('email', $request->email)->first();

    // If the customer is found
    if ($customer && Hash::check($request->password, $customer->password)) {
        // Deactivate the customer's account
        $customer->status = 0; // Assuming 0 means deactivated
        $customer->save();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Account deactivated successfully.');
    } else {
        // If email or password doesn't match
        return back()->with('error', 'Invalid email or password.');
    }
}

    public function staff()
    {
        return view('admin.staff');
    }
   public function deactivateStaff(Request $request)
{
    // Validate input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Check if the email belongs to a staff member
    $staff = Staff::where('email', $request->email)->first();

    // If staff is found
    if ($staff) {
        // Check if the password matches
        if (Hash::check($request->password, $staff->password)) {
            // Deactivate the staff's account
            $staff->status = 0; // Assuming 0 means deactivated
            $staff->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Your account has been deactivated successfully.');
        } else {
            // If password doesn't match
            return back()->with('error', 'Invalid password.');
        }
    }

    // If the staff email doesn't exist
    return back()->with('error', 'Staff not found with the provided email.');
}

}
