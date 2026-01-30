@extends('companyAdmin.layouts.master')
@section('page-title')
    Edit Staff
@endsection
@section('main-content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-staff.update', $staff->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h3 class="card-title">Edit Staff</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" name="name" id="name" class="form-control" value="{{ $staff->name }}">
                                                @error('name')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">Address</label>
                                                <input type="text" name="address" id="address" class="form-control" value="{{ $staff->address }}">
                                                @error('address')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Phone Number</label>
                                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $staff->phone_number }}">
                                                @error('phone_number')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">ID Card Number</label>
                                                <input type="text" name="id_card_no" id="id_card_no" class="form-control" value="{{ $staff->id_card_no }}">
                                                @error('id_card_no')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                         <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Profile Picture</label>
                                                <input type="file" name="staff_img" id="staff_img" class="form-control">
                                                @error('staff_img')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Date Of Birth</label>
                                                <input type="date" name="dob" id="dob" class="form-control" value="{{ $staff->dob }}">
                                                @error('dob')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Joining Date</label>
                                                <input type="date" name="joining_date" id="joining_date" class="form-control" value="{{ $staff->joining_date }}">
                                                @error('joining_date')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Leaving Date</label>
                                                <input type="date" name="leaving_date" id="leaving_date" class="form-control" value="{{ $staff->leaving_date }}">
                                                @error('leaving_date')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                         <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" value="{{ $staff->email }}">
                                                @error('email')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Password</label>
                                                <input type="password" name="password" id="password" class="form-control" value="{{ $staff->confirm_password }}">
                                                @error('password')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Confirm Password</label>
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="{{ $staff->confirm_password }}">
                                                @error('confirm_password')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        </div>
                                        <div class="form-actions mt-5">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-check"></i> Update
                                            </button>
                                            <a href="{{ route('company-staff.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        

@endsection
