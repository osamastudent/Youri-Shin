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
use Auth;
use DB;

class TaxComplianceController extends Controller
{
 public function index()
    {
         $userId = Auth::id();
         $taxCompliance = TaxCompliance::where('created_by', $userId)->get() ;
        return view('companyAdmin.TaxCompliance.index',compact('taxCompliance'));
       
    }
  public function create()
 {

    return view('companyAdmin.TaxCompliance.create');
  }
  
    public function store(Request $request)
    {
         $request->validate([
        'tax_amount' => ['required', 'string', 'max:255'], 
        'tax_rate' => ['required', 'string', 'max:255'],   
        'tax_type' => ['required', 'string', 'in:sales tax,income tax'], 
        'payment_date' => ['required', 'date'], 
        'filing_status' => ['required', 'string', 'max:255'],
             ]);
             
             
    TaxCompliance::create([
        'tax_amount' => $request->tax_amount,
        'tax_rate' => $request->tax_rate,
        'tax_type' => $request->tax_type,
        'payment_date' => $request->payment_date,
        'filing_status' => $request->filing_status,
        'created_by' => Auth::user()->id,
    ]);
        return redirect()->route('company-tax_compliance.index')->with('success', 'Tax Complaince Added Successfully!');
    }
    
 
    
    public function update(Request $request, $id) 
    {  
        $item = TaxCompliance::find($id);
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

        return redirect()->route('company-TaxCompliance.index')->with('success', 'Vendor Updated Successfully!');

       
    }
    
      
    public function edit($id)
    {  
        $items = TaxCompliance::find($id);
       
        return view('companyAdmin.items.edit', compact('items'));
    }
    
        public function delete($id)
    {
        $taxCompliance = TaxCompliance::findOrFail($id); 
        $taxCompliance->delete();
        return redirect()->route('company-tax_compliance.index')->with('success', 'Inventory Managment Deleted Successfully!');
    }
}