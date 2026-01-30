@extends('companyAdmin.layouts.master')
@section('page-title')
    Vendor Details
@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Vendor Details</h3>
                        <hr>
                        <div class="row">
                           
                        </div><br><br>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong class="text-info">Customer Name:</strong> {{ $vendor->name }}</p>
                                <p><strong class="text-info">Address:</strong> {{ $vendor->address }}</p>
                                <p><strong class="text-info">Phone Number:</strong> {{ $vendor->phone_number }}</p>
                                <p><strong class="text-info">Opening Balance:</strong> {{ $vendor->opening_balance }}</p>
                                <p><strong class="text-info">ID Card NO:</strong> {{ $vendor->id_card_no }}</p>
                                
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('company-vendor.index') }}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
