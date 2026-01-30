@extends('admin.layouts.master')
@section('page-title')
    Add Company
@endsection
@section('main-content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form name="formCreate" id="formCreate" method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h3 class="card-title">Add Company</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Company Name</label>
                                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                                @error('name')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                             <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" id="lastName" class="form-control" value="{{ old('email') }}">
                                                @error('email')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Address</label>
                                                <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                                                @error('address')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Contact Number</label>
                                                <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ old('contact_number') }}">
                                                @error('contact_number')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small> 
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Password</label>
                                                <input type="password" name="password" id="password" class="form-control">
                                                @error('password')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <label class="control-label">Confirm password</label>
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                                                @error('confirm_password') 
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Logo</label>
                                                <input type="file" name="logo_img" id="logo_img" class="form-control">
                                                @error('logo_img')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Select Subscription Package</label>
                                                <select name="subscription_id" class="form-control">
                                                    <option value="" disabled selected>-- Select Subscription Package --</option>
                                                    @foreach($packages as $package)
                                                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('subscription_id')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Save
                                    </button>
                                    <a href="{{ route('company.index') }}" type="button" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
