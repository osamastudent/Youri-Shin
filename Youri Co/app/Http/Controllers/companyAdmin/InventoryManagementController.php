<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Zone;
use App\Models\Items;
use App\Models\Payments;
use App\Models\PurchaseOrder;
use App\Models\AccountPayable;
use App\Models\AccountReceivable;
use App\Models\ExpenseTracking;
use App\Models\BudgetingForcasting;
use App\Models\InventoryManagement;
use Auth;
use DB;

class InventoryManagementController extends Controller
{
 public function index()
    {
         $userId = Auth::id();
         $inventoryManagement = InventoryManagement::where('created_by', $userId)->get() ;
        return view('companyAdmin.InventoryManagement.index',compact('inventoryManagement'));
       
    }
  public function create()
 {

    return view('companyAdmin.InventoryManagement.create');
  }
  
    public function store(Request $request)
    {
         $request->validate([
        'product_code' => ['required', 'string', 'max:255'], 
        'product_description' => ['required', 'string','max:255 '], 
        'total_value' => ['required', 'string', 'max:255'], 
        'recorder_point' => ['required', 'string', 'max:255'], 
        'unit_price' => ['required', 'string', 'max:255'], 
        'quantity' => ['required', 'string', 'max:255'], 
        'recorder_quatity' => ['required', 'string', 'max:200'], 
             ]);
             
             
            InventoryManagement::create([
            'product_code' => $request->product_code,
            'product_description' => $request->product_description,
            'total_value' => $request->total_value,
            'recorder_point' => $request->recorder_point,
            'unit_price' => $request->unit_price,
            'quantity' => $request->quantity,
            'recorder_quatity' => $request->recorder_quatity,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-inventory_management.index')->with('success', 'Inventory Management Added Successfully!');
    }
    
 
    
    public function update(Request $request, $id) 
    {  
        $item = Items::find($id);
        $item->update([
            'name' => $request->name,
            'item_type' => $request->item_type,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'tax' => $request->tax,
            'opening_stock' => $request->opening_stock,
            'opening_stock_purschase_price' => $request->opening_stock_purschase_price,
            'barcode_no' => $request->barcode_no,
            // 'price_inculdes_tax' => $request->price_inculdes_tax,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-inventory_management.index')->with('success', 'Vendor Updated Successfully!');

       
    }
    
      
    public function edit($id)
    {  
        $items = Items::find($id);
       
        return view('companyAdmin.items.edit', compact('items'));
    }
    
        public function delete($id)
    {
        $inventoryManagement = InventoryManagement::findOrFail($id); 
        $inventoryManagement->delete();
        return redirect()->route('company-inventory_management.index')->with('success', 'Inventory Managment Deleted Successfully!');
    }
}
