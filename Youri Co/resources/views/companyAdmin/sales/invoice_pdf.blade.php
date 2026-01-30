<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice - {{ $sale->order_unique_id ?? ('SALE-' . $sale->id) }}</title>
  <style>
    /* ===== Page + Font ===== */
    @page { margin: 28px 34px; }
    body{
      font-family: DejaVu Sans, sans-serif; /* dompdf safe */
      font-size: 11px;
      color:#111;
    }
    .muted{ color:#666; }
    .bold{ font-weight:700; }
    .line{
      border-top:2px solid #111;
      margin: 14px 0 18px 0;
    }
    .line-thin{
      border-top:1px solid #e6e6e6;
      margin: 10px 0 0 0;
    }

    /* ===== Top meta row ===== */
    .top-meta{
      width:100%;
      border-collapse:collapse;
      margin-bottom: 8px;
    }
    .top-meta td{
      vertical-align:top;
      padding: 0;
      font-size:10px;
      color:#444;
    }
    .top-right{
      text-align:right;
    }

    /* ===== Header block ===== */
    .header{
      width:100%;
      border-collapse:collapse;
    }
    .header td{
      vertical-align:top;
      padding:0;
    }
    .company-name{
      font-size:20px;
      font-weight:700;
      margin-bottom: 4px;
    }
    .company-lines div{
      margin: 1px 0;
      font-size:10px;
      color:#444;
    }

    .invoice-title{
      text-align:right;
    }
    .invoice-title h1{
      margin:0;
      font-size:28px;
      letter-spacing:0.5px;
      font-weight:800;
    }
    .qr-box{
      margin-top:6px;
      text-align:right;
    }
    .qr-img{
      width:78px;
      height:78px;
      border:1px solid #dcdcdc;
      padding:3px;
      background:#fff;
      display:inline-block;
    }
    .qr-label{
      font-size:7px;
      color:#777;
      margin-top:3px;
      text-transform:uppercase;
      text-align:right;
    }

    /* ===== Addresses ===== */
    .addresses{
      width:100%;
      border-collapse:collapse;
      margin-top: 4px;
    }
    .addresses td{
      width:50%;
      vertical-align:top;
      padding:0 12px 0 0;
    }
    .addresses td:last-child{
      padding-right:0;
      padding-left:12px;
    }
    .sec-title{
      font-size:9px;
      font-weight:700;
      text-transform:uppercase;
      margin-bottom:6px;
      color:#222;
      letter-spacing:0.3px;
    }
    .addr-box{
      border-top:1px solid #e6e6e6;
      padding-top:8px;
      margin-top:6px;
    }
    .addr-box .name{ font-weight:700; margin-bottom:3px; }
    .addr-box div{ margin: 1px 0; color:#333; font-size:10px; }

    /* ===== Details row ===== */
    .details{
      width:100%;
      border-collapse:collapse;
      margin: 18px 0 10px 0;
    }
    .details td{
      width:25%;
      padding: 0 10px 0 0;
      vertical-align:top;
    }
    .details td:last-child{ padding-right:0; }
    .d-label{
      font-size:8px;
      color:#777;
      text-transform:uppercase;
      margin-bottom:2px;
      letter-spacing:0.3px;
    }
    .d-value{
      font-size:10px;
      font-weight:700;
      color:#111;
    }

    /* ===== Items table ===== */
    .items{
      width:100%;
      border-collapse:collapse;
      margin-top: 10px;
    }
    .items th{
      font-size:9px;
      text-transform:uppercase;
      color:#222;
      text-align:left;
      padding: 8px 8px;
      border-bottom:1px solid #e6e6e6;
    }
    .items td{
      padding: 10px 8px;
      border-bottom:1px solid #efefef;
      vertical-align:middle;
      font-size:10px;
    }
    .items tr:last-child td{
      border-bottom: none;
    }
    .center{ text-align:center; }
    .right{ text-align:right; }
    .pimg{
      width:36px;
      height:36px;
      object-fit:cover;
      display:block;
      margin: 0 auto;
    }

    /* ===== Totals ===== */
    .totals{
      width:100%;
      border-collapse:collapse;
      margin-top: 18px;
    }
    .totals td{
      vertical-align:top;
      padding:0;
    }
    .t-left{
      width:60%;
    }
    .t-right{
      width:40%;
      text-align:left;
    }
    .t-row{
      width:100%;
      border-collapse:collapse;
    }
    .t-row td{
      padding: 6px 0;
      font-size:10px;
      color:#444;
    }
    .t-row td:last-child{
      text-align:right;
      font-weight:700;
      color:#111;
    }

    .total-box{
      padding-left: 20px;
    }
    .total-box .label{
      font-size:10px;
      font-weight:700;
      color:#111;
      margin-bottom: 6px;
    }
    .total-box .amount{
      font-size:18px;
      font-weight:800;
      color:#111;
    }

    /* ===== Payment ===== */
    .payment{
      margin-top: 18px;
      padding-top: 14px;
      border-top:2px solid #111;
      font-size:10px;
      color:#111;
    }

    .thanks{
      text-align:center;
      margin-top: 18px;
      font-size:9px;
      color:#666;
    }

    /* ===== Footer (URL + page no) ===== */
    .footer{
      position: fixed;
      left: 34px;
      right: 34px;
      bottom: 18px;
      font-size:8px;
      color:#333;
    }
    .footer-table{
      width:100%;
      border-collapse:collapse;
    }
    .footer-table td{
      padding:0;
      vertical-align:bottom;
    }
    .footer-table td:last-child{
      text-align:right;
    }
  </style>
</head>
<body>

  {{-- Top meta --}}
  <table class="top-meta">
    <tr>
      <td>
        {{ $sale->created_at ? $sale->created_at->format('d/m/Y, H:i') : '' }}
      </td>
      <td class="top-right">
        Invoice - {{ $sale->order_unique_id ?? ('SALE-' . $sale->id) }}
      </td>
    </tr>
  </table>

  {{-- Header --}}
  <table class="header">
    <tr>
      <td style="width:58%;">
        <div class="company-name">{{ $user->name ?? 'N/A' }}</div>
        <div class="company-lines">
          <div>{{ $user->email ?? 'N/A' }}</div>
          <div>{{ $user->address ?? 'N/A' }}</div>
          <div>{{ $user->contact_number ?? 'N/A' }}</div>
          <div>{{ $user->refrel_code ?? 'N/A' }}</div>
        </div>
      </td>

      <td style="width:42%;" class="invoice-title">
        <h1>INVOICE</h1>

        @if(!empty($qrBase64))
          <div class="qr-box">
            <img class="qr-img" src="{{ $qrBase64 }}" alt="QR">
            <div class="qr-label">SCAN TO VERIFY</div>
          </div>
        @endif
      </td>
    </tr>
  </table>

  <div class="line"></div>

  {{-- Addresses --}}
  <table class="addresses">
    <tr>
      <td>
        <div class="sec-title">BILLING ADDRESS:</div>
        <div class="addr-box">
          @if($sale->customer)
            <div class="name">{{ $sale->customer->name }}</div>
            <div>{{ $sale->customer->address }}</div>
            <div>{{ $sale->customer->zone->name ?? '' }}</div>
            <div>Email: {{ $sale->customer->email }}</div>
            <div>Phone: {{ $sale->customer->phone_number }}</div>
          @else
            <div class="name">Customer Information Not Available</div>
          @endif
        </div>
      </td>

      <td>
        <div class="sec-title">SHIPPING ADDRESS:</div>
        <div class="addr-box">
          @if($sale->customer)
            <div class="name">{{ $sale->customer->name }}</div>
            <div>{{ $sale->customer->address }}</div>
            <div>{{ $sale->customer->zone->name ?? '' }}</div>
          @else
            <div class="name">Shipping Information Not Available</div>
          @endif
        </div>
      </td>
    </tr>
  </table>

  {{-- Details --}}
  <table class="details">
    <tr>
      <td>
        <div class="d-label">INVOICE DATE</div>
        <div class="d-value">{{ $sale->created_at?->format('d/M/Y') }}</div>
      </td>
      <td>
        <div class="d-label">INVOICE NO.</div>
        <div class="d-value">{{ $sale->order_unique_id ?? ('INV-' . $sale->id) }}</div>
      </td>
      <td>
        <div class="d-label">ORDER NO.</div>
        <div class="d-value">ORD-{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</div>
      </td>
      <td>
        <div class="d-label">ORDER CODE</div>
        <div class="d-value">{{ $sale->created_at?->format('m/d/Y') }}</div>
      </td>
    </tr>
  </table>

  {{-- Items --}}
  <table class="items">
    <thead>
      <tr>
        <th style="width:10%;">IMAGE</th>
        <th style="width:36%;">PRODUCT</th>
        <th style="width:12%;" class="center">QUANTITY</th>
        <th style="width:14%;" class="right">PRICE</th>
        <th style="width:14%;" class="right">TOTAL PRICE</th>
        <th style="width:14%;" class="right">TOTAL TAX</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $r)
        <tr>
          <td class="center">
            @if(!empty($r['img']))
              <img class="pimg" src="{{ $r['img'] }}" alt="Item">
            @else
              <div class="muted">N/A</div>
            @endif
          </td>
          <td>{{ $r['name'] }}</td>
          <td class="center">{{ $r['qty'] }}</td>
          <td class="right">Rs. {{ number_format($r['unit_price'], 2) }}</td>
          <td class="right">Rs. {{ number_format($r['total'], 2) }}</td>
          <td class="right">Rs. {{ number_format($r['tax'], 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="line-thin"></div>

  {{-- Totals --}}
  <table class="totals">
    <tr>
      <td class="t-left">
        <table class="t-row">
          <tr>
            <td>Subtotal</td>
            <td>Rs. {{ number_format($subtotal, 2) }} <span class="muted">(incl. Tax)</span></td>
          </tr>
          <tr>
            <td>Shipping</td>
            <td class="muted">Flat rate</td>
          </tr>
          @if($discount > 0)
          <tr>
            <td>Cart Discount</td>
            <td>- Rs. {{ number_format($discount, 2) }}</td>
          </tr>
          @endif
        </table>
      </td>

      <td class="t-right">
        <div class="total-box">
          <div class="label">Total</div>
          <div class="amount">Rs. {{ number_format($grandTotal, 2) }}</div>
        </div>
      </td>
    </tr>
  </table>

  {{-- Payment --}}
  <div class="payment">
    <span class="bold">Payment method:</span> {{ ucfirst($sale->payment) }}
  </div>

  <div class="thanks">Thank you for your business.</div>

  {{-- Footer --}}
  <div class="footer">
    <table class="footer-table">
      <tr>
        <td>
          {{ url('/company/sales/' . $sale->id . '/invoice') }}
        </td>
        <td>
          {{-- Page numbers dompdf script below will print --}}
        </td>
      </tr>
    </table>
  </div>

  {{-- DomPDF page numbers --}}
  <script type="text/php">
    if (isset($pdf)) {
      $font = $fontMetrics->get_font("Helvetica", "normal");
      $pdf->page_text(520, 815, "{PAGE_NUM}/{PAGE_COUNT}", $font, 8, array(0,0,0));
    }
  </script>

</body>
</html>