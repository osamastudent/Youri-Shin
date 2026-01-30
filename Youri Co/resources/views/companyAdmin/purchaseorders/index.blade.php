@extends('companyAdmin.layouts.master')
@section('page-title')
    Purchase Order
@endsection
@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">Purchase Order info</h3>
                        <a href="{{ route('company-purchaseorder.create') }}" class="btn btn-info">Create New +</a>
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
                                    <th>Email</th>
                                    <th>Email</th>
                                    <th>ID Card.No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                              <tbody>
                                @foreach($PurchaseOrder as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->po_number }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->supplier_name }}</td>
                                        <td>{{ $item->product_description   }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->unit_price }}</td>
                                        <td>{{ $item->total_cost }}</td>
                                        <td>{{ $item->payment_terms }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td style="display: flex;">
                                            <a href="{{route('company-customer.edit',$item->id)  }}"  class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('company-purchaseorder.delete',$item->id)}}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Delete This ??')"><i class="fa fa-trash"></i></a>
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
