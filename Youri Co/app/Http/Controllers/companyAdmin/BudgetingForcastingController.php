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
use Auth;
use DB;

class BudgetingForcastingController extends Controller
{
 public function index()
    {
         $userId = Auth::id();
         $budgetingForcasting = BudgetingForcasting::where('created_by', $userId)->get() ;
        return view('companyAdmin.BudgetingForcasting.index',compact('budgetingForcasting'));
       
    }
  public function create()
 {

    return view('companyAdmin.BudgetingForcasting.create');
  }
  
    public function store(Request $request)
    {
         $request->validate([
        'budget_period' => ['required', 'string', 'max:255'], 
        'budget_category' => ['required', 'string', 'max:255'], 
        'budget_amount' => ['required', 'string', 'max:255'], 
        'actual_amount' => ['required', 'string', 'max:200'], 
        'variance' => ['required', 'string','max:255 '], 
             ]);
             
             
            BudgetingForcasting::create([
            'budget_period' => $request->budget_period,
            'budget_category' => $request->budget_category,
            'budget_amount' => $request->budget_amount,
            'actual_amount' => $request->actual_amount,
            'variance' => $request->variance,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-budget_forcasting.index')->with('success', 'Budget Forcasting Added Successfully!');
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
