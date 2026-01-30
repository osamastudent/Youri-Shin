@extends('companyAdmin.layouts.master')
@section('page-title')
    Item Details
@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Item Details</h3>
                        <hr>
                         <div class="row">
                            <div class="col-md-4">
                                <img src="/uploads/{{ $items->item_img }}" alt="Banner Image" style="max-width: 200px;" class="img-thumbnail">
                            </div>
                        </div><br><br>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong class="text-info">Item Name:</strong> {{ $items->name }}</p>
                                <p><strong class="text-info">Item Type :</strong> {{ $items->item_type }}</p>
                                <p><strong class="text-info">Sale Price:</strong> {{ $items->sale_price }}</p>
                                <p><strong class="text-info">Purchase Price:</strong> {{ $items->purchase_price }}</p>
                                <p><strong class="text-info">Tax:</strong> {{ $items->tax }}</p>
                                <p><strong class="text-info"> Opening Stock Purchase Price:</strong> {{ $items->opening_stock_purschase_price }}</p>
                                <p><strong class="text-info">Barcode NO:</strong> {{ $items->barcode_no }}</p>
                                
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('company-item.index') }}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
