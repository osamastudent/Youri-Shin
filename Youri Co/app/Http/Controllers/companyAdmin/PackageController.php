<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Zone;
use App\Models\Banners;
use Auth;
use DB;

class PackageController extends Controller
{
  public function index()
    {
        return view('companyAdmin.package.index');
       
    }
  public function create()
 {

    return view('companyAdmin.Banners.create');
  }
  
    public function store(Request $request)
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'banner_img' => ['required', 'image', 'max:2048'],
                 
        ]);
        
        $fileName = null;
        if ($request->hasFile('banner_img')) {
            $file = $request->file('banner_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            // $file->move('../uploads', $fileName);
            $file->move(public_path('./uploads'), $fileName);

        }
        Banners::create([
            'name' => $request->name,
            'banner_img' => $fileName,
            'created_by' => Auth::user()->id,
            'refrel_code' => Auth::user()->refrel_code,
            
        ]);

        return redirect()->route('company-banners.index')->with('success', 'Banner Added Successfully!');
    }
    
   public function show($id)
    {  
        $banners = Banners::find($id);
       
        return view('companyAdmin.Banners.show', compact('banners'));
    }
   public function edit($id)
    {  
        $banners = Banners::find($id);
       
        return view('companyAdmin.Banners.edit', compact('banners'));
    }
    
    
    
    public function update(Request $request, $id) 
    {  
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'banner_img' => ['required', 'image', 'max:2048'],
                 
        ]);
        
        $fileName = null;
        if ($request->hasFile('banner_img')) {
            $file = $request->file('banner_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move('./uploads', $fileName);
        }
        $banners = Banners::find($id);
        $banners->update([
            'name' => $request->name,
            'banner_img'=>$fileName,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-banners.index')->with('success', 'Banner Updated Successfully!');

       
    }
    
      
  
    
        public function delete($id)
    {
        $banners = Banners::findOrFail($id); 
        $banners->delete();
        return redirect()->route('company-banners.index')->with('success', 'Banners Deleted Successfully!');
    }
  
}

