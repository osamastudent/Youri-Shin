@extends('admin.layouts.master')
@section('page-title')
    Company Details
@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Company Details</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="/uploads/{{ $company->logo_img }}" alt="Company Logo" style="max-width: 200px;" class="img-thumbnail">
                            </div>
                        </div><br><br>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong class="text-info">Company Name:</strong> {{ $company->name }}</p>
                                <p><strong class="text-info">Email:</strong> {{ $company->email }}</p>
                                <p><strong class="text-info">Address:</strong> {{ $company->address }}</p>
                                <p><strong class="text-info">Contact Number:</strong> {{ $company->contact_number }}</p>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('company.index') }}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
