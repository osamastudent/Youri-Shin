<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\Staff;
use Auth;

class ExpenseController extends Controller
{
    
   public function index(Request $request)
{
    $query = Expense::join('expense_category', 'expense_category.id', '=', 'expense.category_id')
        ->leftJoin('staff', 'staff.id', '=', 'expense.staff_id') 
        ->select('expense.*', 'expense_category.name as category', 'staff.name as staff')
        ->where('expense_category.created_by', Auth::user()->id);

    // Apply Date Filter
    if ($request->filled('from_date')) {
        $query->whereDate('expense.date', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('expense.date', '<=', $request->to_date);
    }

    $expense = $query->get();

    return view('companyAdmin.expense.index', compact('expense'));
}


   
   public function create()
   {
       $staff = Staff::where('created_by', Auth::user()->id)->get();
       $category = ExpenseCategory::where('created_by', Auth::user()->id)->get();
       return view('companyAdmin.expense.create', compact('category', 'staff'));
   }
   
   public function edit($id)
   {
       $staff = Staff::where('created_by', Auth::user()->id)->get();
       $category = ExpenseCategory::where('created_by', Auth::user()->id)->get();
       $expense = Expense::findOrFail($id);
       return view('companyAdmin.expense.edit', compact('expense', 'category', 'staff'));
   }
   
   public function store(Request $request)
   {
       $request->validate([
            'date' => 'required',
            'category_id' => 'required',
            'amount' => 'required'
       ]);
       
        $fileName = null;
        if ($request->hasFile('expense_img')) {
            $file = $request->file('expense_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('./uploads'), $fileName);

        }
        
       Expense::create([
            'date' => $request->date,
            'category_id' => $request->category_id,
            'staff_id' => $request->staff_id ? $request->staff_id : 0,
            'amount' => $request->amount,
            'note' => $request->note,
            'expense_img' => $fileName,
            'created_by' => Auth::user()->id
       ]);
       
       return redirect()->route('company-expense.index')->with('success', 'Expense Added Successfully!');
   }
   
   public function update(Request $request, $id)
   {
       $expense = Expense::findOrFail($id);
       
       $fileName = $expense->expense_img;
        if ($request->hasFile('expense_img')) {
            $file = $request->file('expense_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('./uploads'), $fileName);

        }
        
       $expense->update([
           'date' => $request->date,
            'category_id' => $request->category_id,
            'staff_id' => $request->staff_id ? $request->staff_id : 0,
            'amount' => $request->amount,
            'expense_img' => $fileName,
            'note' => $request->note,
       ]);
       
       return redirect()->route('company-expense.index')->with('success', 'Expense Updated Successfully!');
   }
   
   public function delete($id)
   {
       $expense = Expense::findOrFail($id);
       $expense->delete();
       return redirect()->route('company-expense.index')->with('success', 'Expense Deleted Successfully!');

   }
   
   
   public function categoryIndex()
   {
       $expenses = ExpenseCategory::where('created_by', Auth::user()->id)->get();
       return view('companyAdmin.expense.expense-category.index', compact('expenses'));
   }
   
   public function categoryCreate()
   {
       return view('companyAdmin.expense.expense-category.create');
   }
   
   public function categoryEdit($id)
   {
       $expense = ExpenseCategory::findOrFail($id);
       return view('companyAdmin.expense.expense-category.edit', compact('expense'));
   }
   
   public function categoryStore(Request $request)
   {
       $request->validate([
            'code' => 'required',
            'name' => 'required'
       ]);
       
       ExpenseCategory::create([
            'code' => $request->code,
            'name' => $request->name,
            'created_by' => Auth::user()->id
       ]);
       
       return redirect()->route('company-expense.category-index')->with('success', 'Expense Category Added Successfully!');
   }
   
   public function categoryUpdate(Request $request, $id)
   {
       $expense = ExpenseCategory::findOrFail($id);
       $expense->update([
            'code' => $request->code,
            'name' => $request->name,
       ]);
       
       return redirect()->route('company-expense.category-index')->with('success', 'Expense Category Updated Successfully!');
   }
   
   public function categoryDelete($id)
   {
       $expense = ExpenseCategory::findOrFail($id);
       $expense->delete();
       return redirect()->route('company-expense.category-index')->with('success', 'Expense Category Deleted Successfully!');

   }
   
}












