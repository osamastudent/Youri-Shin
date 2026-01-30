@extends('companyAdmin.layouts.master')

@section('page-title')
    Order QR Code - {{ $sale->order_unique_id ?? $sale->id }}
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- QR Code Column -->
                        <div class="col-md-6 text-center">
                            @if($sale->qr_code_path)
                                <div class="mb-3">
                                    <img src="{{ asset($sale->qr_code_path) }}" alt="QR Code" 
                                         class="img-fluid" style="max-height: 400px;">
                                </div>
                                
                                <div class="btn-group">
                                    <a href="{{ route('sales.invoice.download', $sale->id) }}" 
                                       class="btn btn-primary">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                    <button onclick="{{ route('sale.invoice', $sale->id) }}" class="btn btn-secondary">
                                        <i class="fa fa-print"></i> Print
                                    </button>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    No QR Code available for this order.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Order Details Column -->
                        <div class="col-md-6">
                            <h4 class="mb-4">Order Details</h4>
                            
                            <div class="order-details">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Order ID:</th>
                                        <td>{{ $sale->order_unique_id ?? $sale->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer:</th>
                                        <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date:</th>
                                        <td>{{ $sale->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount:</th>
                                        <td>${{ number_format($sale->total_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Type:</th>
                                        <td>{{ ucfirst($sale->payment) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            @if($sale->status == 0)
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($sale->status == 1)
                                                <span class="badge badge-success">Completed</span>
                                            @else
                                                <span class="badge badge-secondary">Unknown</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Items:</th>
                                        <td>
                                            @php
                                                $itemIds = explode(', ', $sale->item_id);
                                                $quantities = explode(', ', $sale->buying_qty);
                                                $prices = explode(', ', $sale->unit_price);
                                            @endphp
                                            @foreach($itemIds as $index => $itemId)
                                                @php
                                                    $item = \App\Models\Items::find($itemId);
                                                    $quantity = $quantities[$index] ?? 1;
                                                    $price = $prices[$index] ?? 0;
                                                @endphp
                                                @if($item)
                                                    <div>{{ $item->name }} (x{{ $quantity }}) - ${{ number_format($price, 2) }}</div>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!-- QR Code Data (Hidden by default) -->
                            <div class="mt-4">
                                <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" 
                                        data-target="#qrDataCollapse" aria-expanded="false">
                                    Show QR Code Data
                                </button>
                                
                                <div class="collapse mt-2" id="qrDataCollapse">
                                    <div class="card card-body">
                                        <pre style="font-size: 12px;">{{ json_encode(json_decode($sale->qr_code_data), JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('company-sale.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Sales List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
        .btn-group, .order-details, .collapse {
            display: block !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
    
    .order-details table tr {
        border-bottom: 1px solid #dee2e6;
    }
    
    .order-details table tr:last-child {
        border-bottom: none;
    }
</style>
@endsection