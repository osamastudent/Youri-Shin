@extends('admin.layouts.master')
@section('page-title')
    Subscription Packages
@endsection
@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">Subscription Packages</h3>
                    </div>
                    <hr>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Package Name</th>
                                    <!--<th>Company Setup</th>-->
                                    <!--<th>Staff/Rider</th>-->
                                    <!--<th>Customer</th>-->
                                    <!--<th>Duration (In Month)</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($packages as $key => $item)
                                    <tr>
                                        <td>{{ $key +1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <!--<td>{{ $item->no_of_setup }}</td>-->
                                        <!--<td>{{ $item->no_of_staff }}</td>-->
                                        <!--<td>{{ $item->no_of_customers }}</td>-->
                                        <!--<td>{{ $item->duration }}</td>-->
                                        <td style="display: flex;">
                                            <a href="{{ route('package.edit', $item->id) }}"  class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                         <form action="{{ route('package.delete', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Delete This?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

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
