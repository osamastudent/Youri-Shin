<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Zone;
use App\Models\Package;
use App\Models\Staff;
use App\Models\User;
use Auth;
use DB;
use Hash;

class StaffController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $staff = Staff::where('created_by', $userId)->get();
        return view('companyAdmin.staffs.index', compact('staff'));
    }
public function create()
{
    $currentUser = Auth::user();
    if (!$currentUser) {
        return redirect()->back()->with('error', 'User not authenticated.');
    }

    $companyId = $currentUser->id;
    if (!$companyId) {
        return redirect()->back()->with('error', 'Company ID not found.');
    }

    $company = User::find($companyId);
    if (!$company) {
        return redirect()->back()->with('error', 'Company not found.');
    }
    // dd($company);
    $subscriptionId = $company->subscription_id;
    if (!$subscriptionId) {
        return redirect()->back()->with('error', 'Subscription ID not found.');
    }

    $package = DB::table('packages')->where('id', $subscriptionId)->first();
    if (!$package) {
        return redirect()->back()->with('error', 'Your company does not have a valid subscription package.');
    }

    $allowedstaff = $package->no_of_staff;
    if ($allowedstaff === null) {
        return redirect()->back()->with('error', 'Allowed staff number not defined.');
    }

    $existingstaff = Staff::where('created_by', $currentUser->id)->count();
    if ($existingstaff === null) {
        return redirect()->back()->with('error', 'Could not count existing staff.');
    }
    if($allowedstaff !== 'Unlimited'){

        if ($existingstaff >= $allowedstaff) {
            return redirect()->back()->with('error', 'You have reached the maximum number of allowed Staff for your subscription package!');
        }
    }

    return view('companyAdmin.staffs.create', compact('currentUser', 'companyId', 'subscriptionId', 'package', 'allowedstaff', 'existingstaff'));
}



    public function store(Request $request)
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:20'],
        'dob' => ['required', 'string', 'max:20'],
        'joining_date' => ['required', 'string', 'max:20'],
        'leaving_date' => ['required', 'string', 'max:20'],
        'email' => ['required', 'string', 'email', 'max:255'],            
        'id_card_no' => ['required', 'string', 'max:20'],
         'password' => ['required', 'string' ],
        'confirm_password' => ['required', 'string'],
        ]);
        
        $fileName = null;
        if ($request->hasFile('staff_img')) {
            $file = $request->file('staff_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('./uploads'), $fileName);
        }
        
        Staff::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'staff_img' => $fileName,
            'dob' => $request->dob,
            'joining_date' => $request->joining_date,
            'leaving_date' => $request->leaving_date,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirm_password' => $request->confirm_password,
            'id_card_no' => $request->id_card_no,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-staff.index')->with('success', 'Staff Added Successfully!');
    }
    
 
   
    public function show($id)
    {  
        $staff = Staff::find($id);
       
        return view('companyAdmin.staffs.show', compact('staff'));
    }
    public function edit($id)
    {  
        $staff = Staff::find($id);
       
        return view('companyAdmin.staffs.edit', compact('staff'));
    }
    
    
    public function update(Request $request, $id) 
    {  
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:20'],
        'email' => ['required', 'string', 'email', 'max:255'],            
        'id_card_no' => ['required', 'string', 'max:20'],
        'password' => ['required', 'string' ],
        'confirm_password' => ['required', 'string'],
        'joining_date' => ['required', 'string', 'max:20'],
        'leaving_date' => ['required', 'string', 'max:20'],
        'dob' => ['required', 'string', 'max:20'],
        ]);
        
        
        $staff = Staff::find($id);
        $fileName = $staff->staff_img;
        if ($request->hasFile('staff_img')) {
            $file = $request->file('staff_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('./uploads'), $fileName);
        }
        $staff->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'staff_img' => $fileName,
            'dob' => $request->dob,
            'joining_date' => $request->joining_date,
            'leaving_date' => $request->leaving_date,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirm_password' => $request->confirm_password,
            'id_card_no' => $request->id_card_no,
        ]);

        return redirect()->route('company-staff.index')->with('success', 'Staff Updated Successfully!');

       
    }
    
    
        public function delete($id)
    {
        $zones = Staff::findOrFail($id); 
        $zones->delete();
        return redirect()->route('company-staff.index')->with('success', 'Staff Deleted Successfully!');
    }
    
}
