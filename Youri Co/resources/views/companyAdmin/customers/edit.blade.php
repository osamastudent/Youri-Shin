
@extends('companyAdmin.layouts.master')
@section('page-title')
    Customers
@endsection
@section('main-content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-customer.update', $customer->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h3 class="card-title">Customers Edit</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{$customer->name}}">
                                                @error('name')
                                            <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span>                                               
                                               @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">Address</label>
                                                <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{$customer->address}}">
                                                @error('address')
                                            <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span>                                               
                                               @enderror
                                            </div>
                                        </div>
                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Zone</label>
                                            <select name="zone_id" id="zone_id" class="form-control @error('zone_id') is-invalid @enderror">
                                                
                                                @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}" {{ $customer->zone_id == $zone->id ? 'selected' : '' }}>
                                            {{ $zone->name }}
                                        </option>
                                        @endforeach
                                                                        </select>
                                            @error('zone_id')
                                            <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span>                                               
                                            @enderror
                                        </div>
                                    </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Phone Number</label>
                                                <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{$customer->phone_number}}">
                                                @error('phone_number')
                                            <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span>                                               
                                            @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="control-label">Opening Balance</label>
                                        <input type="number" name="opening_balance" id="opening_balance" class="form-control @error('opening_balance') is-invalid @enderror" value="{{$customer->opening_balance}}">
                                        @error('opening_balance')
                                      <span class="invalid-feedback">
                                         <strong class="text-danger">{{ $message }}</strong>
                                    </span> 
                                        @enderror
                                    </div>
                                </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Opening Stock</label>
                                                <input type="number" name="opening_stock" id="opening_stock" class="form-control @error('opening_stock') is-invalid @enderror" value="{{$customer->opening_stock}}">
                                                @error('opening_stock')
                                              <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span> 
                                                @enderror
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Profile Image</label>
                                                <input type="file" name="profile_image" id="opening_stock" class="form-control @error('profile_image') is-invalid @enderror" >
                                                @error('profile_image')
                                              <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span> 
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">ID Card Number</label>
                                                <input type="text" name="id_card_no" id="id_card_no" class="form-control @error('id_card_no') is-invalid @enderror" value="{{$customer->id_card_no}}">
                                                @error('id_card_no')
                                            <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span>                                               
                                            @enderror
                                            </div>
                                        </div>
                                        
                                        
                                        
                                              <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{$customer->email}}">
                                                @error('email')
                                              <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span> 
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Password</label>
                                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{$customer->confirm_password}}">
                                                @error('password')
                                              <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span> 
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Confirm Password</label>
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" value="{{$customer->confirm_password}}">
                                                @error('confirm_password')
                                              <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span> 
                                                @enderror
                                            </div>
                                        </div>
                                
                                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                <option value="{{ $customer->category }}" selected>
                                    {{ $customer->category }}
                                </option>
                                <!-- Display other category options -->
                                <option value="Domestic">Domestic</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Corporate">Corporate</option>
                            </select>
                            @error('category_id')
                                    <span class="invalid-feedback">
                                         <strong class="text-danger">{{ $message }}</strong>
                                    </span>                                               
                            @enderror
                        </div>
                    </div>

                                        
                                        
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label class="control-label">Location</label>-->
                                        <!--        <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">-->
                                        <!--        @error('location')-->
                                            <!--<span class="invalid-feedback">-->
                                            <!--     <strong class="text-danger">{{ $message }}</strong>-->
                                            <!--</span>                                               -->
                                            <!--        @enderror-->
                                                <!-- Map Container -->
                                        <!--        <div id="map" style="height: 300px; margin-top: 10px;"></div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                             
                             
                                        
                                        </div>
                                    </div>
                                    <div class="form-actions mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Update
                                    </button>
                                    <a href="{{ route('company-customer.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                                </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    <!-- Add this script to your layout or page -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>

<script>
    function initMap() {
        // Initialize map
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644}, // Default center
            zoom: 8 // Default zoom
        });

        // Initialize marker 
        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: {lat: -34.397, lng: 150.644} // Default position
        });

        // Add event listener to update input field when marker position changes
        google.maps.event.addListener(marker, 'dragend', function(event) {
            document.getElementById('location').value = event.latLng.lat() + ', ' + event.latLng.lng();
        });
    }
</script>
@endsection
