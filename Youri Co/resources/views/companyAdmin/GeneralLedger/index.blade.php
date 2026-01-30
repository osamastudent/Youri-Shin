@extends('companyAdmin.layouts.master')
@section('page-title')
General Ledger
@endsection
@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">    General Ledger info</h3>
                        <a href="{{ route('company-general_ledger.create') }}" class="btn btn-info">Create New +</a>
                    </div>
                    <hr>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>PO.NO</th>
                                    <th>date</th>
                                    <th>Supplier Name</th>
                                    <th>Product Description</th>
                                    <th>Quantity</th>
                                    <th>Price Unit</th>
                                    <th>Total Cost</th>
                                    <th>Payment Date</th>
                                    <th>Payment Method</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                                           <tbody>
                           @foreach($generalLedger as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->account_number }}</td>
                                        <td>{{ $item->account_name }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->debit_credit_amount }}</td>
                                        <td>{{ $item->description }}</td>
                                      
                                        <td style="display: flex;">
                                            <a href=""  class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('company-general_ledger.delete',$item->id)}}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Delete This ??')"><i class="fa fa-trash"></i></a>
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
