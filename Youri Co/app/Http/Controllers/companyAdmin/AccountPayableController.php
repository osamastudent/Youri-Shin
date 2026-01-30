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
use Auth;
use DB;

class AccountPayableController extends Controller
{
 public function index()
    {
         $userId = Auth::id();
      $accountPayable = AccountPayable::where('created_by', $userId)->get();
        return view('companyAdmin.AccountPayable.index',compact('accountPayable'));
       
    }
  public function create()
 {

    return view('companyAdmin.AccountPayable.create');
  }
  
    public function store(Request $request)
    {
        $request->validate([
            'invoice_no' => ['required'],
            'date' => ['required'],
            'supplier_name' => ['required'],
            // 'product_description' => ['required'],
            // 'quantity' => ['required'],
            // 'unit_price' => ['required'],
            // 'total_cost' => ['required'],
            // 'payment_terms' => ['required'],
            // 'status' => ['required'],
            
        ]);
            AccountPayable::create([
            'invoice_no' => $request->invoice_no,
            'date' => $request->date,
            'supplier_name' => $request->supplier_name,
            'product_description' => $request->product_description,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_cost' => $request->total_cost,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-account_payable.index')->with('success', 'Account Pay Added Successfully!');
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

        return redirect()->route('company-item.index')->with('success', 'Vendor Updated Successfully!');

       
    }
    
      
    public function edit($id)
    {  
        $items = Items::find($id);
       
        return view('companyAdmin.items.edit', compact('items'));
    }
    
        public function delete($id)
    {
        $zones = AccountPayable::findOrFail($id); 
        $zones->delete();
        return redirect()->route('company-account_payable.index')->with('success', 'Account Payable Deleted Successfully!');
    }
}
