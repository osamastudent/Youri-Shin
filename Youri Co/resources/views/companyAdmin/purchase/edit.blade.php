@extends('companyAdmin.layouts.master')

@section('page-title')
  Add Sales
@endsection
<style>
    .purchase-attachment{
    height:40px;
    width:50px;
}
</style>

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form  method="POST" action="{{ route('company-purchase.update',$edit->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Edit Purchase</h3>
                        
                            <hr>
                            <div class="row p-t-20">

                                <!-- Customer Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">select Vendor</label><br>
                                        <select name="vendor_id" id="vendor_id" class="form-control">
                                            <option value="">Select a Vendor</option>
                                                @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" 
                                                    {{ (old('vendor_id', $edit->vendor_id) == $vendor->id) ? 'selected' : '' }}>
                                                    {{ $vendor->name }}
                                                </option>
                                            @endforeach
 
                                        </select>
                                        @error('vendor_id')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                 
                           
                                
                                <!-- purchased item name Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Purchased Item Name</label>
                                        <input type="text" name="purchased_item_name" value="{{old('purchased_item_name',$edit->purchased_item_name)}}" class="form-control">
                                        @error('purchased_item_name')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                


                                
                                <!-- cost Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cost</label>
                                        <input type="number" name="cost" value="{{ old('cost', number_format($edit->cost, 0, '', '')) }}" class="form-control" step="1">

                                        @error('cost')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                


                                
                                <!-- purchased item name Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Attachment</label>
                                        <input type="file" name="attachment" value="{{old('attachment')}}" class="form-control">
                                        @error('attachment')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                        <img src="{{ asset('uploads/'.$edit->attachment) }}" class="img-thumbnail purchase-attachment mt-2" />
                                    </div>
                                </div>
                                

                            </div> 
                        </div> 
                        
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>

<!-- Handlebars CDN -->
<script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@endsection
