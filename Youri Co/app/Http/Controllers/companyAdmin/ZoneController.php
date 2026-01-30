<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zone;
use Auth;
use DB;

class ZoneController extends Controller
{
    public function index()
    {
         $userId = Auth::id();
         $zones = Zone::where('created_by', $userId)->get();

        return view('companyAdmin.zones.index', compact('zones'));        
    }
    public function create()
    {
        return view('companyAdmin.zones.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
       'name' => ['required', 'string', 'max:255'],
            
        ]);
        

        Zone::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,

        ]);

        return redirect()->route('company-zone.index')->with('success', 'Zone Added Successfully!');
    }
    
    
    public function edit($id)
    {  
          
        $zones = Zone::find($id);
       
        return view('companyAdmin.zones.edit', compact('zones'));
    }
    
    
    public function update(Request $request, $id)
    {  
        $request->validate([
         'name' => ['required', 'string', 'max:255'],
           ]);
        $zones = Zone::find($id);
        $zones->update([
            'name' => $request->name,
        ]);

        return redirect()->route('company-zone.index')->with('success', 'Zone Updated Successfully!');

       
    }
    
    
        public function delete($id)
    {
        $zones = Zone::findOrFail($id);
        $zones->delete();
        return redirect()->route('company-zone.index')->with('success', 'Zone Deleted Successfully!');
    }
    
}
