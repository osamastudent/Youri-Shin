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
use App\Models\PaymentProcessing;
use Auth;
use DB;

class PaymentProcessingController extends Controller
{
 public function index()
    {
         $userId = Auth::id();
         $paymentProcessing = PaymentProcessing::where('created_by', $userId)->get() ;
        return view('companyAdmin.PaymentProcessing.index',compact('paymentProcessing'));
       
    }
  public function create()
 {

    return view('companyAdmin.PaymentProcessing.create');
  }
  
    public function store(Request $request)
    {
         $request->validate([
        'payment_method' => ['required', 'string', 'max:255'], 
        'payment_date' => ['required', 'string','max:255 '], 
        'payment_amount' => ['required', 'string', 'max:255'], 
        'payment_status' => ['required', 'string', 'max:255'], 
             ]);
             
             
            PaymentProcessing::create([
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'payment_amount' => $request->payment_amount,
            'payment_status' => $request->payment_status,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-payment_processing.index')->with('success', 'Payment Proccess Added Successfully!');
    }
    
 
    
    public function update(Request $request, $id) 
    {  
        $item = PaymentProcessing::find($id);
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

        return redirect()->route('company-payment_processing.index')->with('success', 'Vendor Updated Successfully!');

       
    }
    
      
    public function edit($id)
    {  
        $items = PaymentProcessing::find($id);
       
        return view('companyAdmin.items.edit', compact('items'));
    }
    
        public function delete($id)
    {
        $paymentProcessing = PaymentProcessing::findOrFail($id); 
        $paymentProcessing->delete();
        return redirect()->route('company-payment_processing.index')->with('success', 'Payment Processing Deleted Successfully!');
    }
}
