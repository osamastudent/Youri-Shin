@extends('companyAdmin.layouts.master')
@section('page-title')
    Add Vendor
@endsection
@section('main-content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-item.update', $items->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h3 class="card-title">Items Info</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"> Item Name</label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $items->name }}">
                                                @error('name')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="control-label">Item type</label>
                                        <select name="item_type" id="item_type" class="form-control @error('item_type') is-invalid @enderror" value="{{ $items->item_type }}>
                                            <option value="value="">{{ $items->item_type}}</option>
                                                <option value="Finished Good">Finished Good</option>
                                                <option value="Raw Material">Raw Material</option>
                                                <option value="Boths">Boths</option>
                                        </select>

                                    </div>
                                </div>

                                 <div class="col-md-6">
                                           <div class="form-group">
    <label class="control-label">Item Image</label>
    <input type="file" name="item_img" id="item_img" class="form-control @error('item_img') is-invalid @enderror">
    @error('item_img')
        <small class="form-control-feedback text-danger">{{ $message }}</small>
    @enderror

    {{-- Show old image preview if exists --}}
    @if($items->item_img)
        <div class="mt-2">
            <img src="{{ asset('uploads/'.$items->item_img) }}" alt="Item Image" width="120" class="img-thumbnail">
        </div>
    @endif
</div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Sale Price</label>
                                                <input type="text" name="sale_price" id="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ $items->sale_price }}">
                                                @error('sale_price')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Purchase Price</label>
                                                <input type="purchase_price" name="purchase_price" id="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ $items->purchase_price }}">
                                                @error('purchase_price')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Tax</label>
                                                <input type="text" name="tax" id="tax" class="form-control @error('tax') is-invalid @enderror" value="{{ $items->tax }}">
                                                @error('tax')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        


                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Opening Stock</label>
                                                <input type="text" name="opening_stock" id="opening_stock" class="form-control @error('opening_stock') is-invalid @enderror" value="{{ $items->opening_stock }}">
                                                @error('opening_stock')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Opening Stock Purchase Price(per unit)</label>
                                                <input type="text" name="opening_stock_purschase_price" id="opening_stock_purschase_price" class="form-control @error('opening_stock_purschase_price') is-invalid @enderror" value="{{ $items->opening_stock_purschase_price }}">
                                                @error('opening_stock_purchase_price')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="control-label">Barcode no</label>
                                                <input type="text" name="barcode_no" id="barcode_no" class="form-control @error('barcode_no') is-invalid @enderror" value="{{ $items->barcode_no }}">
                                                @error('barcode_no')
                                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                <!--       <div class="col-md-6">-->
                                <!--    <div class="form-group"> -->
                                <!--        <label class="control-label">Price Includes Tax</label>-->
                                <!--        <div class="form-check">-->
                                <!--            <input type="checkbox" name="price_includes_tax" id="price_includes_tax" class="form-check-input" value="yes">-->
                                <!--            <label class="form-check-label" for="price_includes_tax">Includes Tex</label>-->
                                <!--        </div>-->
                                <!--        @error('price_includes_tax')-->
                                <!--            <small class="form-control-feedback text-danger">{{ $message }}</small>-->
                                <!--        @enderror-->
                                <!--    </div>-->
                                <!--</div>-->
                                                            
                                        

                             
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Update
                                    </button>
                                    <a href="#" type="button" class="btn btn-inverse">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
@endsection
