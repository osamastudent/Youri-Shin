@extends('companyAdmin.layouts.master')
@section('page-title')
    Expenses
@endsection
@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">Expenses</h3>
                        <!-- Add Create New Button -->
                        <a href="{{ route('company-expense.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Create New
                        </a>
                    </div>
                    <!-- Date Filter Form -->
                    <form action="{{ route('company-expense.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="from_date">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="to_date">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Date</th>
                                    <th>Staff/Company</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Image</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expense as $key => $item)
                                    <tr>
                                        <td>{{ $key +1 }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>
                                            @if($item->staff_id == 0)
                                                {{ Auth::user()->name }}
                                            @else
                                                {{ $item->staff }}
                                            @endif
                                        </td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td><img src="/uploads/{{ $item->expense_img }}" width="150" height="150" class="img-thumbnail" alt="{{ $item->category }}"></td>
                                        <td>{{ $item->note }}</td>
                                        <td style="display: flex;">
                                            <a href="{{ route('company-expense.edit', $item->id) }}" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('company-expense.delete', $item->id) }}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Delete This ??')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
