<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Zone;
use App\Models\User;
use App\Models\Brand;
use App\Models\Chat;
use App\Models\Staff;
use App\Models\Package;
use Auth;
use DB;
use Hash;


class ChatController extends Controller

{
    public function index()
    {
        $userId = Auth::id();
        $staffMembers = Staff::where('created_by', $userId)->get();
        return view('companyAdmin.chats.index', compact('staffMembers'));
    }

    public function chat($id)
    {
        $staffMember = Staff::findOrFail($id);
        $chats = DB::table('chats')
            ->select('chats.*', 'staff.name as staff_name', 'users.name as company_name')
            ->leftJoin('staff', 'chats.staff_id', '=', 'staff.id')
            ->leftJoin('users', 'chats.company_id', '=', 'users.id')
            ->where(function ($query) use ($id) {
                $query->where('chats.company_id', Auth::id())
                      ->where('chats.staff_id', $id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('chats.staff_id', $id)
                      ->where('chats.company_id', Auth::id());
            })
            ->orderBy('chats.created_at')
            ->get();

        if (request()->ajax()) {
            return response()->json(['staffMember' => $staffMember, 'chats' => $chats]);
        }


        return view('companyAdmin.chats.show', compact('staffMember', 'chats'));
    }
    
    public function loadMorechats(Request $request)
    {
        $oldestMessageId = $request->input('oldest_message_id');
    
        $chatsQuery = DB::table('chats')
            ->select('chats.*', 'staff.name as staff_name', 'users.name as company_name')
            ->leftJoin('staff', 'chats.staff_id', '=', 'staff.id')
            ->leftJoin('users', 'chats.company_id', '=', 'users.id')
            ->where(function ($query) use ($id) {
                $query->where('chats.company_id', Auth::id())
                      ->where('chats.staff_id', $id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('chats.staff_id', $id)
                      ->where('chats.company_id', Auth::id());
            });
    
        if ($oldestMessageId) {
            $chats = $chatsQuery->where('chats.id', '<', $oldestMessageId)->orderByDesc('chats.created_at')->limit(10)->get();
        } else {
            $chats = $chatsQuery->orderByDesc('chats.created_at')->limit(10)->get();
        }
    
    dd($chatsQuery);
    
        return response()->json(['chats' => $chats]);
    }


    public function sendMessage(Request $request)
    {
        $message = new Chat();
        $message->company_id = Auth::id();
        $message->staff_id = $request->input('to_user_id');
        $message->message = $request->input('message');
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension(); 
            $file->move('./uploads/', $fileName);
            $message->file = $fileName;
        }
        $message->save();

        return redirect()->route('company-chat.show', ['id' => $request->input('to_user_id')]);
    }
    
    public function create()
    {
    
        return view('companyAdmin.Brand.create');
    } 
  
    public function store(Request $request)
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'brand_image' => ['required', 'image', 'max:2048'],
                 
        ]);
        
        $fileName = null;
        if ($request->hasFile('brand_image')) {
            $file = $request->file('brand_image');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            // $file->move('../uploads', $fileName);
            $file->move(public_path('./uploads'), $fileName);

        }
        Brand::create([
            'name' => $request->name,
            'brand_image' => $fileName,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-brand.index')->with('success', 'Brand Added Successfully!');
    }
    
    public function show($id)
    {  
        $brand = Brand::find($id);
       
        return view('companyAdmin.Brand.show', compact('brand'));
    }
    public function edit($id)
    {  
        $brand = Brand::find($id);
       
        return view('companyAdmin.Brand.edit', compact('brand'));
    }
    
    
    
    public function update(Request $request, $id) 
    {  
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'brand_image' => ['required', 'image', 'max:2048'],
                 
        ]);
        
        $fileName = null;
        if ($request->hasFile('brand_image')) {
            $file = $request->file('brand_image');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move('./uploads', $fileName);
        }
        $brand = Brand::find($id);
        $brand->update([
            'name' => $request->name,
            'brand_image'=>$fileName,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-brand.index')->with('success', 'Brand Updated Successfully!');

       
    }
    
      
  
    
    public function delete($id)
    {
        $brand = Brand::findOrFail($id); 
        $brand->delete();
        return redirect()->route('company-brand.index')->with('success', 'Brand Deleted Successfully!');
    }
}
