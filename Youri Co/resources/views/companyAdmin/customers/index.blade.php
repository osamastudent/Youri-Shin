@extends('companyAdmin.layouts.master')
@section('page-title')
    Customers
@endsection
@section('main-content')
<style>
    .switch-container {
        position: relative;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 40px;  
        height: 20px; 
    }

    .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 10px; 
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px; 
        width: 16px;  
        left: 2px;    
        bottom: 2px;  
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%; 
    }

    input:checked + .slider {
        background-color: #01C0C8;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #01C0C8;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(20px); 
        -ms-transform: translateX(20px); 
        transform: translateX(20px); 
    }

    .badge {
        position: 
        top: 3px; 
        margin-left: 10px; 
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                   
                   <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="card-title">Customer info</h3>

    <div>
        <button class="btn btn-success" data-toggle="modal" data-target="#importModal">
            Import Excel
        </button>
        <a href="{{ route('company-customer.create') }}" class="btn btn-info">
            Create New +
        </a>
    </div>
</div>

                   
                    <hr>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Customer Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                           
                             <tbody>
                                @foreach($customer as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="switch-container">
                                            <form action="{{ route('company-customer.updateStatus', $item->id) }}" method="POST"> 
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="{{ $item->status ? 0 : 1 }}">
                                                <label class="switch">
                                                    <input type="checkbox" {{ $item->status ? 'checked' : '' }} onchange="this.form.submit()">
                                                    <span class="slider"></span>
                                                </label>
                                                <span class="badge {{ $item->status ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $item->status ? 'Activated' : 'Deactivated' }}
                                                </span>
                                            </form>
                                        </td>
                                        <td style="display: flex;">
                                            <a href="{{route('company-customer.show',$item->id)  }}"  class="btn btn-secondary" style="margin-right: 5px;"><i class="fa fa-eye"></i></a>
                                            <a href="{{route('company-customer.edit',$item->id)  }}"  class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('company-customer.delete',$item->id)}}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Delete This ??')"><i class="fa fa-trash"></i></a>
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


<!-- Import Excel Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('company-customer.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Customers from Excel</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Excel File (.xlsx, .csv)</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <small class="text-muted">
                        Columns must match customer fields.
                    </small>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
