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
                            <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-customer.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h3 class="card-title">Customers Info</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
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
                                                <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
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
                                                <option value="">Select a Zone</option>
                                                @foreach ($zones as $zone)
                                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
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
                                                <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}">
                                                @error('phone_number')
                                               <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                </span> 
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">ID Card Number</label>
                                                <input type="text" name="id_card_no" id="id_card_no" class="form-control @error('id_card_no') is-invalid @enderror"  value="{{ old('id_card_no') }}">
                                                @error('id_card_no')
                                              <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span> 
                                                @enderror
                                            </div>
                                        </div>
                                        
                                <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="control-label">Category</label>
                                        <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" >
                                            <option value="">Select a Category</option>
                                                <option value="Domestic">Domestic</option>
                                                <option value="Commercial">Commercial</option>
                                                <option value="Corporate">Corporate</option>
                                        </select>
                                        @error('category')
                                             <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span> 
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="control-label">Opening Balance</label>
                                        <input type="number" name="opening_balance" id="opening_balance" class="form-control @error('opening_balance') is-invalid @enderror">
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
                                                <input type="number" name="opening_stock" id="opening_stock" class="form-control @error('opening_stock') is-invalid @enderror">
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
                                                <input type="file" name="profile_image" id="profile_image" class="form-control @error('profile_image') is-invalid @enderror">
                                                @error('profile_image')
                                              <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span> 
                                                @enderror
                                            </div>
                                        </div>
                                <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror">
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
                                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
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
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror">
                                                @error('confirm_password')
                                              <span class="invalid-feedback">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span> 
                                                @enderror
                                            </div>
                                        </div>
                                        
                                  {{--      <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
                                        <style>
                                             #map {
                                            height: 500px;
                                            width: 100%;
                                        }

                                        </style>
                                        
                                        <div class="col-md-6">
                                            <div id="map" style="height: 300px; margin-top: 10px;"></div>
                                            <input id="latitude" type="hidden" name="latitude" value="{{ old('latitude') }}">
                                            <input id="longitude" type="hidden" name="longitude" value="{{ old('longitude') }}">
                                        </div>
                                       --}}
                                        </div>
                                    </div>
                                    <div class="form-actions mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Save
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

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([30.3753, 69.3451], 6); // Default center and zoom level (Pakistan)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var marker = L.marker([30.3753, 69.3451], { draggable: true }).addTo(map);

    // Update latitude and longitude inputs based on marker movement
    marker.on('dragend', function (e) {
        var latlng = marker.getLatLng();
        document.getElementById('latitude').value = latlng.lat.toFixed(6);
        document.getElementById('longitude').value = latlng.lng.toFixed(6);
    });

    // Initialize map based on default marker position
    var latitudeInput = document.getElementById('latitude').value;
    var longitudeInput = document.getElementById('longitude').value;

    if (latitudeInput && longitudeInput) {
        marker.setLatLng([latitudeInput, longitudeInput]).addTo(map);
        map.setView([latitudeInput, longitudeInput], 13);
    }

    // Update marker position on map click
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
        document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
    });
</script>
        
@endsection
