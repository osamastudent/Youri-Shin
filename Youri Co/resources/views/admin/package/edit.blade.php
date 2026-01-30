@extends('admin.layouts.master')
@section('page-title')
    Add Subscription Packages
@endsection
@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('package.update', $package->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Add Subscription Packages</h3>
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Package Name</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $package->name }}">
                                        @error('name')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">No Of Company Admins</label>
                                        <input type="number" name="no_of_admins" id="no_of_admins" class="form-control @error('no_of_admins') is-invalid @enderror" value="{{ $package->no_of_admins }}">
                                        @error('no_of_admins')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">No Of Company Setup</label>
                                        <input type="number" name="no_of_setup" id="no_of_setup" class="form-control @error('no_of_setup') is-invalid @enderror" value="{{ $package->no_of_setup }}">
                                        @error('no_of_setup')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">No Of Staff/Rider</label>
                                        <input type="number" name="no_of_staff" id="no_of_staff" class="form-control @error('no_of_staff') is-invalid @enderror" value="{{ $package->no_of_staff }}">
                                        @error('no_of_staff')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">No Of Customers</label>
                                        <input type="number" name="no_of_customers" id="no_of_customers" class="form-control @error('no_of_customers') is-invalid @enderror" value="{{ $package->no_of_customers }}">
                                        @error('no_of_customers')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Duration (In Months)</label>
                                        <input type="number" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ $package->duration }}">
                                        @error('duration')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Price</label>
                                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ $package->price }}">
                                        @error('price')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-actions mt-5">
                            <button type="submit" class="btn btn-primary" id="postButton" >
                                Update
                            </button>
                            <a href="{{ route('package.index') }}" type="button" class="btn btn-secondary">Cancel</a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Include Sweet Alert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
