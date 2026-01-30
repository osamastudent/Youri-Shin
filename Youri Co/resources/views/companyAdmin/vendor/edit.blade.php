@extends('companyAdmin.layouts.master')
@section('page-title')
    Edit Vendor
@endsection
@section('main-content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-vendor.update', $vendor->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h3 class="card-title">Vendor Info</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" name="name" id="name" class="form-control  @error('name') is-invalid @enderror" value="{{$vendor->name }}">
                                              
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">Address</label>
                                                <input type="text" name="address" id="address" class="form-control  @error('address') is-invalid @enderror" value="{{$vendor->address}}">
                                              
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Phone Number</label>
                                                <input type="text" name="phone_number" id="phone_number" class="form-control  @error('phone_number') is-invalid @enderror" value="{{$vendor->phone_number }}">
                                              
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Opening balance</label>
                                                <input type="opening_balance" name="opening_balance" id="opening_balance" class="form-control  @error('opening_balance') is-invalid @enderror" value="{{ $vendor->opening_balance }}">
                                              
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control  @error('email') is-invalid @enderror" value="{{ $vendor->email }}">

                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">ID Card Number</label>
                                                <input type="text" name="id_card_no" id="id_card_no" class="form-control  @error('id_card_no') is-invalid @enderror" value="{{ $vendor->id_card_no }}">

                                            </div>
                                        </div>
                                    
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Update
                                    </button>
                                    <a href="{{ route('company-vendor.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        

@endsection
