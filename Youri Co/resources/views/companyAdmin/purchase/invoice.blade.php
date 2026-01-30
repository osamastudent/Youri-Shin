@extends('companyAdmin.layouts.master')
@section('page-title')
Invoice
@endsection
@section('main-content')
<style>
    body {
        font-family: Arial, sans-serif;
        color: black; /* Set text color to black */
    }
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
</style>

<div class="invoice-box">
    <table>
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <img src="/uploads/{{ Auth::user()->logo_img }}" width="70" height="70" class="rounded-circle" >
                        </td>
                        <td>
                            Invoice #: {{ $sale->id }}<br>
                            Created: {{ $sale->created_at }}<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            <strong>From:</strong><br>
                            {{ $sale->customer_name }}<br>
                            {{ $sale->address }}<br>
                            {{ $sale->phone_number }}
                        </td>
                        <td>
                            <strong>To:</strong><br>
                            {{ Auth::user()->address }}<br>
                            {{ Auth::user()->contact_number }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="heading">
            <td>Item</td>
            <td>Quantity</td>
            <td>Price</td>
        </tr>
        @if ($sale->items)
            @foreach ($sale->items as $item)
                <tr class="item">
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->pivot->buying_qty }}</td>
                    <td>{{ $item->pivot->unit_price }}</td>
                </tr>
            @endforeach
        @else
            <tr class="item">
                <td colspan="3">No items found.</td>
            </tr>
        @endif
        <tr class="total">
            <td></td>
            <td></td>
            <td>Total: Rs: {{ $sale->total_amount }}/=</td>
        </tr>
    </table>
</div>
<script>
    window.onload = function() {
        window.print();
    }
</script>

@endsection
