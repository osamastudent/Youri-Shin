@extends('companyAdmin.layouts.master')
@section('page-title')
    Edit Expense
@endsection
@section('main-content')
        <div class="container-fluid">
            <div class="row"> 
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-expense.update', $expense->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h3 class="card-title">Edit Expense</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Date</label>
                                                <input type="date" name="date" id="date" class="form-control" value="{{ $expense->date }}">
                                                @error('date')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Category</label>
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value="">Select Category</option>
                                                    @foreach($category as $category)
                                                         <option value="{{ $category->id }}" {{ $category->id == $expense->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row p-t-20">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Staff</label>
                                                <select name="staff_id" id="staff_id" class="form-control">
                                                    <option value="">Select Staff</option>
                                                    @foreach($staff as $staff)
                                                         <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('satff_id')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Amount</label>
                                                <input type="text" name="amount" id="amount" class="form-control" value="{{ $expense->amount }}">
                                                @error('amount')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Image</label>
                                                <input type="file" name="expense_img" id="expense_img" class="form-control" value="">
                                                @error('expense_img')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Note</label>
                                                <textarea name="note" id="note" class="form-control" rows="5">{{ $expense->note }}</textarea>
                                                @error('category')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                <div class="form-actions mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Update
                                    </button>
                                    <a href="{{ route('company-expense.index') }}" type="button" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
