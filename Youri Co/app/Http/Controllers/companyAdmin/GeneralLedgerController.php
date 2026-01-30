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
use App\Models\GeneralLedger;
use Auth;
use DB;

class GeneralLedgerController extends Controller
{
 public function index()
    {
         $userId = Auth::id();
      $generalLedger = GeneralLedger::where('created_by', $userId)->get() ;
        return view('companyAdmin.GeneralLedger.index',compact('generalLedger'));
       
    }
  public function create()
 {

    return view('companyAdmin.GeneralLedger.create');
  }
  
    public function store(Request $request)
    {
        $request->validate([
            'account_number' => ['required'],
            'date' => ['required'],
            // 'product_description' => ['required'],
            // 'quantity' => ['required'],
            // 'unit_price' => ['required'],
            // 'total_cost' => ['required'],
            // 'payment_terms' => ['required'],
            // 'status' => ['required'],
            
        ]);
            GeneralLedger::create([
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'date' => $request->date,
            'debit_credit_amount' => $request->debit_credit_amount,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-general_ledger.index')->with('success', 'General ledger Added Successfully!');
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
        $zones = GeneralLedger::findOrFail($id); 
        $zones->delete();
        return redirect()->route('company-general_ledger.index')->with('success', 'Account Receive Deleted Successfully!');
    }
}
