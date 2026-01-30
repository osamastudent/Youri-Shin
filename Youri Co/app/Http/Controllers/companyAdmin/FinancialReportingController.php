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
use App\Models\TaxCompliance;
use App\Models\FinancialReporting;
use Auth;
use DB;


class FinancialReportingController extends Controller
{
 public function index()
    {
         $userId = Auth::id();
         $financialReporting = FinancialReporting::where('created_by', $userId)->get() ;
        return view('companyAdmin.FinancialReporting.index',compact('financialReporting'));
       
    }
  public function create()
 {

    return view('companyAdmin.FinancialReporting.create');
  }
  
    public function store(Request $request)
    {
         $request->validate([
        'report_type' => ['required', 'string', 'max:255'], 
        'report_date' => ['required', 'string','max:255 '], 
        'account_name' => ['required', 'string', 'max:255'], 
        'debit_credit_amount' => ['required', 'string', 'max:255'], 
             ]);
             
             
            FinancialReporting::create([
            'report_type' => $request->report_type,
            'report_date' => $request->report_date,
            'account_name' => $request->account_name,
            'debit_credit_amount' => $request->debit_credit_amount,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-financial_reporting.index')->with('success', 'Financial Report Added Successfully!');
    }
    
 
    
    public function update(Request $request, $id) 
    {  
        $item = FinancialReporting::find($id);
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

        return redirect()->route('company-financial_reporting.index')->with('success', 'Vendor Updated Successfully!');

       
    }
    
      
    public function edit($id)
    {  
        $items = FinancialReporting::find($id);
       
        return view('companyAdmin.items.edit', compact('items'));
    }
    
        public function delete($id)
    {
        $financialReporting = FinancialReporting::findOrFail($id); 
        $financialReporting->delete();
        return redirect()->route('company-financial_reporting.index')->with('success', 'Financial Reporting Deleted Successfully!');
    }
}
