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
use Auth;
use DB;

class ExpenseTrackingController extends Controller
{
 public function index()
    {
         $userId = Auth::id();
        $expenseTracking = ExpenseTracking::where('created_by', $userId)->get() ;
        return view('companyAdmin.ExpenseTracking.index',compact('expenseTracking'));
       
    }
  public function create()
 {

    return view('companyAdmin.ExpenseTracking.create');
  }
  
    public function store(Request $request)
    {
         $request->validate([
        'expense_date' => ['required', 'date'], 
        'category' => ['required', 'string', 'max:255'], 
        'amount' => ['required', 'numeric', 'min:0'], 
        'description' => ['required', 'string', 'max:500'], 
        'payment_method' => ['required', 'string','max:255 '], 
             ]);
             
             
            ExpenseTracking::create([
            'expense_date' => $request->expense_date,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'payment_method' => $request->payment_method,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-expense_tracking.index')->with('success', 'Expense Tracking Added Successfully!');
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
        $expenseTracking = ExpenseTracking::findOrFail($id); 
        $expenseTracking->delete();
        return redirect()->route('company-expense_tracking.index')->with('success', 'Expense Tracking Deleted Successfully!');
    }
}
