@extends('companyAdmin.layouts.master')
@section('page-title')
    Edit Expense Category
@endsection
@section('main-content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-expense.category-update', $expense->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h3 class="card-title">Edit Expense Category</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Code</label>
                                                <input type="text" name="code" id="code" class="form-control" value="{{ $expense->code }}">
                                                @error('code')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" name="name" id="name" class="form-control" value="{{ $expense->name }}">
                                                @error('name')
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
                                    <a href="{{ route('company-expense.category-index') }}" type="button" class="btn btn-inverse">Cancel</a>
                                </div>
                            </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
