@extends('companyAdmin.layouts.master')
@section('page-title')
Banners
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
                        <h3 class="card-title">Banners info</h3>
                        <a href="{{ route('company-banners.create') }}" class="btn btn-info">Create New +</a>
                    </div>
                    <hr>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Baners Name</th>
                                    <th>Banner Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($banners as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <img src="/uploads/{{ $item->banner_img }}" alt="Item Image" width="100" height="100" style="max-width:100%; height:auto;" class="img-thumbnail">
                                        </td>
                                        <td class="switch-container">
                                            <form action="{{ route('company-banners.statusUpdate', $item->id) }}" method="POST"> 
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
                                            <!--<a href="{{route('company-banners.show',$item->id)  }}"  class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-eye"></i></a>-->
                                            <a href="{{route('company-banners.edit',$item->id)  }}"  class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('company-banners.delete',$item->id)}}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Delete This ??')"><i class="fa fa-trash"></i></a>
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
