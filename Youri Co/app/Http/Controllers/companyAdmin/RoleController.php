<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Zone;
use App\Models\Items;
use App\Models\Sales;
use Auth;
use DB;


class RoleController extends Controller
{
 public function index()
    {
           
    //  $sale=Sales::all(); ,compact('sales')
    return view('companyAdmin.roles.index');
       
    }
    
 
  public function create()
 {

    return view('companyAdmin.roles.create');
  }
  
    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required'],
            
        ]);
        

        Sales::create([
            'date' => $request->date,
            'note' => $request->note,
            'customer_id' => $request->customer_id,
            'payment' => $request->payment,
            'cash_collected' => $request->cash_collected,
            'cash_received' => $request->cash_received,
            'balance' => $request->balance,
            'bank_account' => $request->bank_account,
            'transaction_id' => $request->transaction_id,
            'transaction_date' => $request->transaction_date,
            'receive_amount' => $request->receive_amount,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-sale.index')->with('success', 'Sale Added Successfully!');
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
        $sales = Sales::findOrFail($id); 
        $sales->delete();
        return redirect()->route('company-sale.index')->with('success', 'Sale Deleted Successfully!');
    }

}
