@extends('companyAdmin.layouts.master')
@section('page-title')
    Customer Details
@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Customer Details</h3>
                        <hr>
                        <div class="row">
                           
                        </div><br><br>
                        <div class="row mt-3">
                            
                              <div class="col-md-4">
                                <img src="/uploads/{{ $customer->profile_image }}" alt="profile Image" style="max-width: 200px;" class="img-thumbnail">
                            </div>
                        <br><br>
                            <div class="col-md-6">
                                <p><strong class="text-info">Customer Name:</strong>&nbsp;&nbsp; {{ $customer->name }}</p>
                                <p><strong class="text-info">Address:</strong>&nbsp;&nbsp; {{ $customer->address }}</p>
                                <p><strong class="text-info">Phone Number:</strong>&nbsp;&nbsp; {{ $customer->phone_number }}</p>
                                <p><strong class="text-info">Category:</strong>&nbsp;&nbsp; {{ $customer->category }}</p>
                                <p><strong class="text-info">Email:</strong>&nbsp;&nbsp; {{ $customer->email }}</p>
                                <p><strong class="text-info"> Password:</strong>&nbsp;&nbsp; {{ $customer->confirm_password }}</p>
                                <p><strong class="text-info">ID Card NO:</strong>&nbsp;&nbsp; {{ $customer->id_card_no }}</p>
                                <p><strong class="text-info">Status:</strong>&nbsp;&nbsp; <span class="badge {{ $customer->status ? 'badge-success' : 'badge-danger' }}">{{ $customer->status ? 'Activated' : 'Deactivated' }}</span></p>
                                
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('company-customer.index') }}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
