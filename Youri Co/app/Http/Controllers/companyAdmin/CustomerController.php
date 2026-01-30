<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Zone;
use App\Models\User;
use App\Models\Package;
use Auth;
use DB;
use Hash;

use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::Join('zone', 'zone.id', '=', 'customers.zone_id')
        ->select('customers.*', 'zone.name as zone_name')->where('customers.created_by',Auth::user()->id)
        ->get();

    return view('companyAdmin.customers.index', compact('customer'));
       
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
    
        $subscriptionId = $company->subscription_id;
        if (!$subscriptionId) {
            return redirect()->back()->with('error', 'Subscription ID not found.');
        }
    
        $package = DB::table('packages')->where('id', $subscriptionId)->first();
        if (!$package) {
            return redirect()->back()->with('error', 'Your company does not have a valid subscription package.');
        }
    
        $allowedcustomer = $package->no_of_customers;
        if ($allowedcustomer === null) {
            return redirect()->back()->with('error', 'Allowed Customer number not defined.');
        }
    
        $existingcustomer = Customer::where('created_by', $currentUser->id)->count();
        if ($existingcustomer === null) {
            return redirect()->back()->with('error', 'Could not count existing Customer.');
        }
    
        if ($allowedcustomer !== 'Unlimited') {
            if ($existingcustomer >= $allowedcustomer) {
                return redirect()->back()->with('error', 'You have reached the maximum number of allowed Customers for your subscription package!');
            }
        }
    
        $userId = Auth::id();
        $zones = Zone::where('created_by', $userId)->get();
    
        return view('companyAdmin.customers.create', compact('zones', 'currentUser', 'companyId', 'subscriptionId', 'package', 'allowedcustomer', 'existingcustomer'));
    }

  
   public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'zone_id' => ['required', 'numeric'],
        'address' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:20'],
        'category' => ['required', 'string', 'max:255'],
        'opening_balance' => ['required', 'string', 'max:255'],
        'opening_stock' => ['required', 'string', 'max:255'],
        'id_card_no' => ['required', 'string', 'max:20'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => ['required', 'string'],
        'confirm_password' => ['required', 'string', 'same:password'],
    ]);
    
    $fileName = null;
    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
        $file->move(public_path('./uploads'), $fileName);
    }
    
    $customer = Customer::create([
        'name' => $request->name,
        'zone_id' => $request->zone_id,
        'address' => $request->address,
        'phone_number' => $request->phone_number,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'category' => $request->category,
        'opening_balance' => $request->opening_balance,
        'opening_stock' => $request->opening_stock,
        'profile_image' => $fileName,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'confirm_password' => $request->confirm_password,
        'id_card_no' => $request->id_card_no,
        'created_by' => Auth::user()->id,
        'refrel_code' => Auth::user()->refrel_code,
        'status' => 1
    ]);
    
    // Check if request is AJAX
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Customer Added Successfully!',
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone_number' => $customer->phone_number,
            ]
        ]);
    }
    
    return redirect()->route('company-customer.index')->with('success', 'Customer Added Successfully!');
}
    
    public function show($id)
    {  
        $customer = Customer::find($id);
        return view('companyAdmin.customers.show', compact('customer'));
    }
    
    public function edit($id)
    {  
        $customer = Customer::find($id);
        $userId = Auth::id();
        $zones = Zone::where('created_by', $userId)->get();
        return view('companyAdmin.customers.edit', compact('customer', 'zones'));
    }
    
    
        
public function update(Request $request, $id)
{
    
    $request->validate([
       'name' => ['required', 'string', 'max:255'],
        'zone_id' => ['required', 'numeric'],
        'address' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:20'],
        'category' => ['required', 'string', 'max:255'],
        'id_card_no' => ['required', 'string', 'max:20'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => ['required', 'string' ],
        'confirm_password' => ['required', 'string'],
            ]);
    $Customer = Customer::find($id);

    if ($request->input('category') !== $Customer->category) {
        $Customer->category = $request->input('category');
    }
     $fileName = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            // $file->move('../uploads', $fileName);
            $file->move(public_path('./uploads'), $fileName);

        }

    // Update other fields
    $Customer->update([
        'name' => $request->name,
        'zone_id' => $request->zone_id,
        'address' => $request->address,
        'opening_balance' => $request->opening_balance,
        'opening_stock' => $request->opening_stock,
        'profile_image' => $fileName,
        'phone_number' => $request->phone_number,
        'id_card_no' => $request->id_card_no,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'confirm_password' => $request->confirm_password,
        'created_by' => Auth::user()->id,
    ]);
        return redirect()->route('company-customer.index')->with('success', 'Customer Edit Successfully!');
    }

        public function delete($id)
    {
        $zones = Customer::findOrFail($id); 
        $zones->delete();
        return redirect()->route('company-customer.index')->with('success', 'customer Deleted Successfully!');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $customer = Customer::find($id);
        $referringUser = User::find($customer->created_by);
        $subscriptionId = $referringUser->subscription_id;
        $package = Package::where('id', $subscriptionId)->first();
        $allowedCustomer = $package->no_of_customers;
        $activeCustomerCount = Customer::where('created_by', $referringUser->id)
        ->where('status', 1)
        ->count();

        if ($request->status == 1 && $allowedCustomer !== 'Unlimited' && $activeCustomerCount >= $allowedCustomer) {
            return redirect()->back()->with('error', 'Cannot activate customer. The maximum number of allowed customers has been reached for your subscription package.');
        }

        $customer->status = $request->status;
        $customer->save();

        $statusMessage = $customer->status ? 'Activated' : 'Deactivated';
        return redirect()->back()->with('success', "Customer $statusMessage successfully!");
    }
    
    
    
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv'
    ]);
    
    

    Excel::import(new CustomersImport, $request->file('file'));

    return redirect()->route('company-customer.index')
        ->with('success', 'Customers Imported Successfully!');
}
    
}
