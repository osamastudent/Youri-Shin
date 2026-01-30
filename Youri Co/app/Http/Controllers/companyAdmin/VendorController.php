<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Zone;
use App\Models\Vendor;
use Auth;
use DB;


class VendorController extends Controller
{
    public function index()
    {
       $userId = Auth::id();
        $vendor = Vendor::where('created_by', $userId)->get();
    return view('companyAdmin.vendor.index', compact('vendor'));
       
    }
  public function create()
 {

    return view('companyAdmin.vendor.create');
  }
  
    public function store(Request $request)
    {
   $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'phone_number' => ['required','string', 'max:255'],
        'opening_balance' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email'],
        'id_card_no' => ['required', 'string', 'max:255'],
        ]);
        

        Vendor::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'opening_balance' => $request->opening_balance,
            'email' => $request->email,
            'id_card_no' => $request->id_card_no,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-vendor.index')->with('success', 'Vendor Added Successfully!');
    }
    
     
    public function show($id)
    {  
        $vendor = Vendor::find($id);
       
        return view('companyAdmin.vendor.show', compact('vendor'));
    }
 
    
    public function update(Request $request, $id) 
    {  
         $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'phone_number' => ['required','string', 'max:255'],
        'opening_balance' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email'],
        'id_card_no' => ['required', 'string', 'max:255'],
        ]);
        
        $vendor = Vendor::find($id);
        $vendor->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'opening_balance' => $request->opening_balance,
            'email' => $request->email,
            'id_card_no' => $request->id_card_no,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('company-vendor.index')->with('success', 'Vendor Updated Successfully!');

       
    }
    
      
    public function edit($id)
    {  
        $vendor = Vendor::find($id);
       
        return view('companyAdmin.vendor.edit', compact('vendor'));
    }
    
        public function delete($id)
    {
        $zones = Vendor::findOrFail($id); 
        $zones->delete();
        return redirect()->route('company-vendor.index')->with('success', 'Vendor Deleted Successfully!');
    }
    
}
