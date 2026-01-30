<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use Auth;

class CompanyController extends Controller
{
    public function index()
    {
        $company = User::join('packages', 'packages.id', '=', 'users.subscription_id')->select('users.*', 'packages.name as package')->where('user_type', 2)->get();
       return view('admin.company.index', compact('company'));
    }
    
    public function create()
    {
        $packages = Package::all();
        return view('admin.company.create', compact('packages'));
    }
    
    function generateUniqueReferralCode() {
        do {
            // Generate a random four-digit number
            $refrel_code = rand(1000, 9999);
        } while (User::where('refrel_code', $refrel_code)->exists());
    
        return $refrel_code;
    }

    
//   public function store(Request $request)
// {
//     $request->validate([
//         'name' => ['required'],
//         'email' => ['required', 'unique:users,email'],
//         'address' => ['required'],
//         'contact_number' => ['required', 'numeric'],
//         'password' => ['required'],
//         'subscription_id' => ['required'], // keep as-is
//         'confirm_password' => ['required', 'same:password']
//     ]);

//     $refrel_code = $this->generateUniqueReferralCode();

//     $fileName = null;
//     if ($request->hasFile('logo_img')) {
//         $file = $request->file('logo_img');
//         $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension(); 
//         $file->move('./uploads/', $fileName);
//     }

//     // ✅ Create company (as before)
//     $company = User::create([
//         'name' => $request->name,
//         'email' => $request->email,
//         'address' => $request->address,
//         'contact_number' => $request->contact_number,
//         'password' => Hash::make($request->password),
//         'confirm_password' => $request->confirm_password,
//         'subscription_id' => $request->subscription_id, // keep original purpose
//         'user_type' => 2,
//         'status' => 1,
//         'created_by' => Auth::user()->id,
//         'logo_img' => $fileName,
//         'refrel_code' => $refrel_code,
//     ]);

//     // ✅ Automatically associate with all 3 default subscription_data entries
//     $defaultSubscriptions = \App\Models\SubscriptionData::all();

//     foreach ($defaultSubscriptions as $subscription) {
//         $company->subscriptionData()->attach($subscription->id, ['status' => 'active']);
//     }

//     return redirect()->route('company.index')->with('success', 'Company Added Successfully!');
// }


public function store(Request $request)
{
    $request->validate([
        'name' => ['required'],
        'email' => ['required', 'unique:users,email'],
        'address' => ['required'],
        'contact_number' => ['required', 'numeric'],
        'password' => ['required'],
        'subscription_id' => ['required'],
        'confirm_password' => ['required', 'same:password']
    ]);

    $refrel_code = $this->generateUniqueReferralCode();

    $fileName = null;
    if ($request->hasFile('logo_img')) {
        $file = $request->file('logo_img');
        $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension(); 
        $file->move('./uploads/', $fileName);
    }

    // ✅ Create company
    $company = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'address' => $request->address,
        'contact_number' => $request->contact_number,
        'password' => Hash::make($request->password),
        'confirm_password' => $request->confirm_password,
        'subscription_id' => $request->subscription_id,
        'user_type' => 2,
        'status' => 1,
        'created_by' => Auth::user()->id,
        'logo_img' => $fileName,
        'refrel_code' => $refrel_code,
    ]);

    // ✅ Attach all default subscriptions
    $defaultSubscriptions = \App\Models\SubscriptionData::all();
    foreach ($defaultSubscriptions as $subscription) {
        $company->subscriptionData()->attach($subscription->id, ['status' => 'active']);
    }

  // ✅ Automatically create default “19 Litre Water Bottle” item for this company
\App\Models\Items::create([
    'name' => '19 Litre Water Bottle',
    'sale_price' => 100, // default sale price       
    'barcode_no' => '' . strtoupper(uniqid()), // unique barcode   
    'item_img' => '19litrewaterbottle.png', // put your default image in public/uploads/
    'created_by' => $company->id, // company’s user id
    'refrel_code' => $company->refrel_code,
    
]);

    return redirect()->route('company.index')->with('success', 'Company Added Successfully!');
}

    
    
    public function show($id) 
    {
        $company = User::find($id);
        return view('admin.company.show', compact('company'));
    }
    
    
    
    public function edit($id) 
    {
        $company = User::find($id);
        $packages = Package::all();
        return view('admin.company.edit', compact('company', 'packages'));
    }
    
     public function update(Request $request, $id)
    {
        $company = User::find($id);
        
        $currentImage = $company->logo_img;
        
        $fileName = null;
    	if (request()->hasFile('logo_img')) 
    	{
    		$file = request()->file('logo_img');
    		$fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
    		$file->move('./uploads/', $fileName);
    	}
        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->password),
            'confirm_password' => $request->confirm_password,
            'subscription_id' => $request->subscription_id,
            'logo_img' => ($fileName) ? $fileName : $currentImage,
        ]);
        
        return redirect()->route('company.index')->with('success', 'Company Updated Successfully!');
    }
    
    public function delete($id)
    {
        $company = User::find($id);
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Company Deleted Successfully!');
    }
    
    
    public function changeStatus(Request $request, $id)
    {
        $company = User::find($id);
        $company->status = $request->status;
        $company->save();
        
        $statusMessage = $company->status ? 'Activated' : 'Deactivated';
        return redirect()->back()->with('success', "Company $statusMessage successfully!");
    }

}
