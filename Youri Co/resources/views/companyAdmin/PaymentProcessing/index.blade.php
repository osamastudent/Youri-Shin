@extends('companyAdmin.layouts.master')
@section('page-title')
    Payment Proccessing
@endsection
@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">Payment Proccessing info</h3>
                        <a href="{{ route('company-payment_processing.create') }}" class="btn btn-info">Create New +</a>
                    </div>
                    <hr>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Vendor Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Opening balance</th>
                                    <th>Email</th>
                                    <th>ID Card.No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                               <tbody>
                           @foreach($paymentProcessing as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>{{ $item->payment_date }}</td>
                                        <td>{{ $item->payment_amount }}</td>
                                        <td>{{ $item->payment_status}}</td>

                                        <td style="display: flex;">
                                            <a href=""  class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('company-payment_processing.delete',$item->id)}}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Delete This ??')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            </tbody>
                        </table>
                    </div>
                </div> 
            </div> 
        </div>
    </div>
</div>

                            @endsection
