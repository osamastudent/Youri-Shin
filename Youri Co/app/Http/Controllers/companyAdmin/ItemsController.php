<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Customer;
use App\Models\Zone;
use App\Models\Items;
use Auth;
use DB;

class ItemsController extends Controller
{
    
 public function index()
{
    $userId = Auth::id();

    $items = Items::where('created_by', $userId)->get();


    return view('companyAdmin.items.index', compact('items'));
}

  public function create()
 {

    return view('companyAdmin.items.create');
  }
  
    public function store(Request $request)
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'item_type' => ['required', 'string', 'max:255'],
        'sale_price' => ['required', 'numeric', 'min:0'],
        'purchase_price' => ['required', 'numeric', 'min:0'],
        'tax' => ['required', 'numeric', 'min:0', 'max:100'],
        'opening_stock' => ['required', 'string', 'max:255'],
        'opening_stock_purschase_price' => ['required', 'numeric', 'min:0'],
        'barcode_no' => ['required', 'string', 'max:255', 'regex:/^\d+$/', 'unique:items,barcode_no'],
        'item_img' => ['required', 'image', 'max:2048'],            
        ]);
        
         
        $fileName = null;
        if ($request->hasFile('item_img')) {
            $file = $request->file('item_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('./uploads'), $fileName);
        }
        Items::create([
            'name' => $request->name,
            'item_type' => $request->item_type,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'tax' => $request->tax,
            'opening_stock' => $request->opening_stock,
            'opening_stock_purschase_price' => $request->opening_stock_purschase_price,
            'barcode_no' => $request->barcode_no,
            'item_img' => $fileName,
            // 'price_inculdes_tax' => $request->price_inculdes_tax,
            'created_by' => Auth::user()->id,
            'refrel_code' => Auth::user()->refrel_code,
            
        ]);

        return redirect()->route('company-item.index')->with('success', 'Item Added Successfully!');
    }
    
 
    
    public function update(Request $request, $id) 
    {  
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'item_type' => ['required', 'string', 'max:255'],
        'sale_price' => ['required', 'numeric', 'min:0'],
        'purchase_price' => ['required', 'numeric', 'min:0'],
        'tax' => ['required', 'numeric', 'min:0', 'max:100'],
        'opening_stock' => ['required', 'string', 'max:255'],
        'opening_stock_purschase_price' => ['required', 'numeric', 'min:0'],
       'barcode_no' => [
            'required',
            'string',
            'max:255',
            'regex:/^\d+$/',
            Rule::unique('items', 'barcode_no')->ignore($id) // 👈 important
        ],
        'item_img' => [ 'image', 'max:2048'],            
        ]);
         $item = Items::findOrFail($id);
    $fileName = $item->item_img; // purani image ko default rakho
        if ($request->hasFile('item_img')) {
            $file = $request->file('item_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('./uploads'), $fileName);
        }
        
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
            'item_img' => $fileName,
            // 'price_inculdes_tax' => $request->price_inculdes_tax,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-item.index')->with('success', 'Items Updated Successfully!');

       
    }
    
      
    public function show($id)
    {  
        $items = Items::find($id);
       
        return view('companyAdmin.items.show', compact('items'));
    }
    public function edit($id)
    {  
        $items = Items::find($id);
       
        return view('companyAdmin.items.edit', compact('items'));   
    }
    
    
public function delete($id)
{
    $item = Items::findOrFail($id);
    
    $item->delete();

    return redirect()->route('company-item.index')->with('success', 'Item deleted successfully.');
}

  
}
