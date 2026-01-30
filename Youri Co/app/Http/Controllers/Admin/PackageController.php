<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Package;
use Auth;

class PackageController extends Controller
{
    public function index()
    {
       $packages = Package::all();
       return view('admin.package.index', compact('packages'));
    }
    
    public function create()
    {
        $packageCount = Package::count();
        if ($packageCount >= 3) {
            return redirect()->route('package.index')->with('error', 'You Can Only Create 3 Packages');
        }
    
        return view('admin.package.create');
    }
    
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.package.edit', compact('package'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'no_of_admins' => ['required'],
            'no_of_setup' => ['required'],
            'duration' => ['required'],
        ]);
        
        Package::create([
            'name' => $request->name,
            'no_of_admins' => $request->no_of_admins,
            'no_of_setup' => $request->no_of_setup,
            'no_of_staff' => $request->no_of_staff ? $request->no_of_staff : 'Unlimited',
            'no_of_customers' => $request->no_of_customers ? $request->no_of_customers : 'Unlimited',
            'duration' => $request->duration,
            'price' => $request->price,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('package.index')->with('success', 'Package Added Successfully!');
    }
    
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $package->update([
            'name' => $request->name,
            'no_of_admins' => $request->no_of_admins,
            'no_of_setup' => $request->no_of_setup,
            'no_of_staff' => $request->no_of_staff,
            'no_of_customers' => $request->no_of_customers,
            'duration' => $request->duration,
            'price' => $request->price
        ]);
        
        return redirect()->route('package.index')->with('success', 'Package Added Successfully!');
    }
    
    public function delete($id)
    {
        $package = Package::find($id);
        $package->delete();
        return redirect()->route('package.index')->with('success', 'Package Deleted Successfully!');
    }

}
