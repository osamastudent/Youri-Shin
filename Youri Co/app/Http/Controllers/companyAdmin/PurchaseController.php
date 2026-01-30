<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Zone;
use App\Models\Items;
use App\Models\Sales;
use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Staff;
use Auth; 
use DB;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    
            // show purchase records
           public function index(Request $request)
        {
            $purchases = Purchase::with('vendor')->where('created_by', Auth::user()->id)->orderBy('created_at','desc')->get();
            
            return view('companyAdmin.purchase.index', compact('purchases'));
        }


    public function create()
    {
        $userId = Auth::id();
        $vendors = Vendor::where('created_by', $userId)->get();
        return view('companyAdmin.purchase.create',compact('vendors'));
     }
  
  // store data into purchase table
    public function store(Request $request)
    { 
        $request->validate([
            'vendor_id'=>'required',
            'purchased_item_name'=>'required',
            'cost'=>'required',
            'attachment' => 'required|mimes:jpg,jpeg,png,gif,bmp,webp',  // Allow all common image types
            ]);
    
        $file = $request->file('attachment'); 
        $fileName = null;
          
        if ($file) {
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
        }
    
        Purchase::create([
            'vendor_id' => $request->vendor_id,
            'purchased_item_name' => $request->purchased_item_name,
            'cost' => $request->cost,
            'attachment' => $fileName,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('company-purchase.index')->with('success', 'Purchase Added Successfully!');
    }

    
     
    //  edit form
    public function edit($id)
    {  
        
        $edit = Purchase::find($id);
        $userId = Auth::id();
        $vendors = Vendor::where('created_by', $userId)->get();
        
       if(!$edit){
           return redirect()->route('company-purchase.index')->with('success', 'Record not found.');
       }
        return view('companyAdmin.purchase.edit', compact('edit','vendors'));
    }
    
   
    
    // update data into purchase table
    public function update(Request $request, $id)
{  
    $request->validate([
        'vendor_id' => 'required',
        'purchased_item_name' => 'required',
        'cost' => 'required',
       'attachment' => 'nullable|mimes:jpg,jpeg,png,gif,bmp,webp',  // Allow all common image types
  
    ]);

    $update = Purchase::findOrFail($id); // Find the record by ID

    if ($update) {
        // Get the file from the request
        $file = $request->file('attachment');
        $fileName = $update->attachment; // Default to old file name

        if ($file) {
            // If there is a new file, delete the old file first (if it exists)
            if (file_exists(public_path('uploads/' . $update->attachment))) {
                unlink(public_path('uploads/' . $update->attachment)); // Delete the old file
            }

            // Generate a new file name and store the file
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
        }

        // Update the record with the new or old file name
        $update->update([
            'vendor_id' => $request->vendor_id,
            'purchased_item_name' => $request->purchased_item_name,
            'cost' => $request->cost,
            'attachment' => $fileName, // Store the new or old file name
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect to the index page with success message
        return redirect()->route('company-purchase.index')->with('success', 'Purchase updated successfully!');
    } else {
        // If the record was not found, return with an error message
        return redirect()->route('company-purchase.index')->with('error', 'Record not found.');
    }
}

 // delete record
        public function delete($id)
    {
        $delete = Purchase::findOrFail($id); 
         if(!$delete){
           return redirect()->route('company-purchase.index')->with('success', 'Record not found.');
       }
        $delete->delete();
        return redirect()->route('company-purchase.index')->with('success', 'Purchase Deleted Successfully!');
    }

}
