@extends('companyAdmin.layouts.master')
@section('page-title')
Sales Details
@endsection
@section('main-content')
<style>
    .badge-ordered {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #17a2b8; /* Teal background */
        color: #ffffff; /* White text */
    }
    
    .badge-assigned {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #fb9678; /* Green background */
        color: #ffffff; /* White text */
    }
    
    .badge-in-process {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #ffc107; /* Yellow background */
        color: #ffffff; /* White text */
    }
    
    .badge-delivering {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #007bff; /* Blue background */
        color: #ffffff; /* White text */
    }
    
    .badge-delivered {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #28a745; /* Green background */
        color: #ffffff; /* White text */
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">Order #{{ $sale->id }}</h3>
                        <!-- Display status badge here -->
                        @if ($sale->status == 0)
                            <span class="badge badge-ordered">Ordered</span>
                        @elseif ($sale->status == 1)
                            <span class="badge badge-assigned">Assigned</span>
                        @elseif ($sale->status == 2)
                            <span class="badge badge-in-process">Preparing</span>
                        @elseif ($sale->status == 3)
                            <span class="badge badge-delivering">Dispatched</span>
                        @elseif ($sale->status == 4)
                            <span class="badge badge-delivered">Delivered</span>
                        @endif
                    </div>
                    <!--@if ($sale->status != 0)-->
                    <!--    <h5 class="card-title"><strong>Assigned To:</strong>&nbsp;&nbsp; {{ $sale->staff }}</h5>-->
                    <!--@endif-->
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Customer Information</h4>
                            <p><strong>Name:</strong> {{ $sale->customer_name }}</p>
                            <p><strong>Phone Number:</strong> {{ $sale->phone_number }}</p>
                            <p><strong>Address:</strong> {{ $sale->address }}</p>
                            <p><strong>Zone:</strong> {{ $sale->zone }}</p>
                        </div>
                        <div class="col-md-6">
                            <h4 class="card-title">Sale Information</h4>
                            <p><strong>Total Amount:</strong> {{ $sale->total_amount }}</p>
                            <p><strong>Payment Type:</strong> {{ $sale->payment }}</p>
                            @if($sale->payment == 'cash')
                                <p><strong>Cash Received:</strong> {{ $sale->cash_received }}</p>
                                <p><strong>Balance:</strong> {{ $sale->balance }}</p>
                            @endif
                            <p><strong>Note:</strong> {{ $sale->note }}</p>
                            <p><strong>Empty Bottles:</strong> {{ $sale->bottles }}</p>
                            @if($sale->status == 4)
                            <p><strong>Water Bottles Received:</strong> {{ $sale->bottle_recieve }}</p>
                            @endif
                            <p><strong>Ordered At:</strong> {{ $sale->created_at }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">Items</h4>
                            <ul>
                                @foreach ($sale->getItemsArray1() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="col-6">
                            <h4 class="card-title">Status</h4>
                            @if($sale->status == 0)
                                <img src="/dist/ordered.gif" width="300" height="200">
                            @elseif($sale->status == 1)
                                <img src="/dist/assigned.gif" width="300" height="200">
                            @elseif($sale->status == 2)
                                <img src="/dist/preparing.gif" width="300" height="200">
                            @elseif($sale->status == 3)
                                <img src="/dist/dispatching.gif" width="300" height="200">
                            @elseif($sale->status == 4)
                                <img src="/dist/delivered.gif" width="300" height="200">
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('company-sale.index') }}" class="btn btn-secondary">Back to Sales List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
