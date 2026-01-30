@extends('admin.layouts.master')
@section('page-title')
     Company
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
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <h3 class="card-title">Companies</h3>
                            <hr>
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Company Name</th>
                                    <th>Subscription Package</th>
                                    <th>Status</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($company as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->package }}</td>
                                    <td class="switch-container">
                                        <form action="{{ route('company.changeStatus', $item->id) }}" method="POST">
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
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('company.show', $item->id) }}" class="btn btn-secondary mx-2">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('company.edit', $item->id) }}" class="btn btn-primary mx-2">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="{{ route('company.delete', $item->id) }}" class="btn btn-danger mx-2" onclick="return confirm('Are You Sure You Want To Delete This?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
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
