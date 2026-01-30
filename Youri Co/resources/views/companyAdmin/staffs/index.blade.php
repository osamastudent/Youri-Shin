@extends('companyAdmin.layouts.master')
@section('page-title')
    Staff
@endsection
@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">Staff info</h3>
                        <a href="{{ route('company-staff.create') }}" class="btn btn-info">Create New +</a>
                    </div>
                    <hr>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Staff Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                              <tbody>
                                @foreach($staff as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                      <td>
                                            <a href="{{route('company-staff.show',$item->id)  }}"  class="btn btn-primary" style="margin-right: 5px;"><i class="fa fa-eye"></i></a>
                                            <a href="{{route('company-staff.edit',$item->id)  }}"  class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('company-staff.delete',$item->id)}}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Delete This ??')"><i class="fa fa-trash"></i></a>
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
