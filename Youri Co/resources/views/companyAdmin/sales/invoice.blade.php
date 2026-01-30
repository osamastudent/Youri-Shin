<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $sale->order_unique_id ?? 'SALE-' . $sale->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
            padding: 20px;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            position: relative;
        }
        
        /* Header Section with QR Code */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #000;
            position: relative;
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: 700;
            color: #000;
            margin-bottom: 5px;
        }
        
        .company-address {
            color: #666;
            margin-bottom: 3px;
        }
        
        .invoice-title-section {
            text-align: right;
        }
        
        .invoice-title {
            font-size: 32px;
            font-weight: 700;
            color: #000;
            margin-bottom: 10px;
        }
        
        .qr-code-header {
            text-align: center;
        }
        
        .qr-code-image {
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            padding: 3px;
            background: white;
            margin: 0 auto 5px;
        }
        
        .qr-code-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
        }
        
        /* Rest of your CSS styles remain the same... */
        .address-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 25px;
        }
        
        .address-box {
            padding: 10px 0;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: 600;
            color: #000;
            text-transform: uppercase;
            margin-bottom: 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }
        
        .address-content {
            color: #333;
        }
        
        .address-name {
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .address-line {
            margin-bottom: 2px;
        }
        
        .invoice-details-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        
        .detail-value {
            font-weight: 600;
            color: #000;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        
        .products-table th {
            background: #f5f5f5;
            padding: 10px;
            text-align: left;
            font-weight: 600;
            color: #000;
            border-bottom: 2px solid #ddd;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .products-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        
        .products-table tr:last-child td {
            border-bottom: 2px solid #000;
        }
        
        .product-name {
            font-weight: 500;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .totals-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .totals-left {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .total-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        
        .total-label {
            color: #666;
        }
        
        .total-value {
            font-weight: 600;
        }
        
        .grand-total {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
        }
        
        .grand-total-label {
            font-size: 14px;
            font-weight: 600;
            color: #000;
            margin-bottom: 5px;
        }
        
        .grand-total-value {
            font-size: 24px;
            font-weight: 700;
            color: #000;
        }
        
        .payment-section {
            margin-bottom: 25px;
            padding-top: 20px;
            border-top: 2px solid #000;
        }
        
        .payment-method {
            font-weight: 600;
            color: #000;
            margin-bottom: 5px;
        }
        
        .invoice-footer {
            text-align: center;
            color: #666;
            font-size: 11px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .invoice-container {
                max-width: 100%;
                margin: 0;
                padding: 20px;
            }
            
            .no-print {
                display: none !important;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .print-button:hover {
            background: #45a049;
        }
        
        .empty-row {
            height: 40px;
        }
        
        .empty-row td {
            border: none !important;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        <i class="fa fa-print"></i> Print Invoice
    </button>
    
    <div class="invoice-container">
        <!-- Header with QR Code -->
        <div class="invoice-header">
            <div class="company-info">
                <div class="company-name">{{ $user->name ?? 'N/A' }}</div>
                <div class="company-address">{{ $user->email ?? 'N/A' }}</div>
                <div class="company-address">{{ $user->address ?? 'N/A' }}</div>
                <div class="company-address">{{ $user->contact_number ?? 'N/A' }}</div>
                <div class="company-address">{{ $user->refrel_code ?? 'N/A' }}</div>
               

            </div>
            
            <div class="invoice-title-section">
                <div class="invoice-title">INVOICE</div>
                
                @if($sale->qr_code_path)
                <div class="qr-code-header">
                    <img src="{{ asset($sale->qr_code_path) }}" 
                         alt="Order QR Code" 
                         class="qr-code-image">
                    <div class="qr-code-label">
                        Scan to verify
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Addresses Section -->
        <div class="address-section">
            <!-- Billing Address -->
            <div class="address-box">
                <div class="section-title">Billing Address:</div>
                <div class="address-content">
                    @if($sale->customer)
                        <div class="address-name">{{ $sale->customer->name }}</div>
                        <div class="address-line">{{ $sale->customer->address }}</div>
                        <div class="address-line">{{ $sale->customer->zone->name ?? '' }}</div>
                        <div class="address-line">Email: {{ $sale->customer->email }}</div>
                        <div class="address-line">Phone: {{ $sale->customer->phone_number }}</div>
                    @else
                        <div class="address-name">Customer Information Not Available</div>
                    @endif
                </div>
            </div>
            
            <!-- Shipping Address -->
            <div class="address-box">
                <div class="section-title">Shipping Address:</div>
                <div class="address-content">
                    @if($sale->customer)
                        <div class="address-name">{{ $sale->customer->name }}</div>
                        <div class="address-line">{{ $sale->customer->address }}</div>
                        <div class="address-line">{{ $sale->customer->zone->name ?? '' }}</div>
                    @else
                        <div class="address-name">Shipping Information Not Available</div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Invoice Details -->
        <div class="invoice-details-grid">
            <div class="detail-item">
                <span class="detail-label">Invoice Date</span>
                <span class="detail-value">{{ $sale->created_at->format('d/M/Y') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Invoice No.</span>
                <span class="detail-value">{{ $sale->order_unique_id ?? 'INV-' . $sale->id }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Order No.</span>
                <span class="detail-value">ORD-{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Order Code</span>
                <span class="detail-value">{{ $sale->created_at->format('m/d/Y') }}</span>
            </div>
        </div>
        
        <!-- Products Table -->
        <table class="products-table">
            <thead>
                <tr>
                    <th>IMAGE</th>
                    <th>PRODUCT</th>
                    <th class="text-center">QUANTITY</th>
                    <th class="text-right">PRICE</th>
                    <th class="text-right">TOTAL PRICE</th>
                    <th class="text-right">TOTAL TAX</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $itemIds = explode(', ', $sale->item_id);
                    $quantities = explode(', ', $sale->buying_qty);
                    $unitPrices = explode(', ', $sale->unit_price);
                    $buyingPrices = explode(', ', $sale->buying_price);
                    $subtotal = 0;
                    $totalTax = 0;
                @endphp
                
                @foreach($itemIds as $index => $itemId)
                    @php
                        $item = \App\Models\Items::find($itemId);
                        $quantity = $quantities[$index] ?? 1;
                        $unitPrice = $unitPrices[$index] ?? 0;
                        $totalPrice = $buyingPrices[$index] ?? 0;
                        $tax = $totalPrice * 0.10;
                        
                        $subtotal += $totalPrice;
                        $totalTax += $tax;
                    @endphp
                    
                    <tr>
                        <td class="text-center">
                            @if($item && $item->item_img)
                              <img src="{{ asset('uploads/' . $item->item_img) }}"
                                     alt="Item Image"
                                     width="50"
                                     height="50"
                                     style="object-fit: cover;">


                            @else
                                <div style="width: 50px; height: 50px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; color: #999;">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td class="product-name">
                            {{ $item->name ?? 'Item ' . ($index + 1) }}
                        </td>
                        <td class="text-center">{{ $quantity }}</td>
                        <td class="text-right">Rs. {{ number_format($unitPrice, 2) }}</td>
                        <td class="text-right">Rs. {{ number_format($totalPrice, 2) }}</td>
                        <td class="text-right">Rs. {{ number_format($tax, 2) }}</td>
                    </tr>
                @endforeach
                
                @if(count($itemIds) < 2)
                    @for($i = count($itemIds); $i < 2; $i++)
                        <tr class="empty-row">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>
        
        <!-- Totals Section -->
        <div class="totals-section">
            <div class="totals-left">
                @php
                    $shipping = 0;
                    $discount = $sale->coupon_code ? 270.00 : 0;
                    $grandTotal = $subtotal + $shipping - $discount;
                @endphp
                
                <div class="total-item">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">Rs. {{ number_format($subtotal, 2) }} (incl. Tax)</span>
                </div>
                
                <div class="total-item">
                    <span class="total-label">Shipping</span>
                    <span class="total-value">Flat rate</span>
                </div>
                
                @if($discount > 0)
                <div class="total-item">
                    <span class="total-label">Cart Discount:</span>
                    <span class="total-value">- Rs. {{ number_format($discount, 2) }}</span>
                </div>
                @endif
            </div>
            
            <div class="grand-total">
                <div class="grand-total-label">Total</div>
                <div class="grand-total-value">Rs. {{ number_format($grandTotal, 2) }}</div>
            </div>
        </div>
        
        <!-- Payment Method -->
        <div class="payment-section">
            <div class="payment-method">
                Payment method: {{ ucfirst($sale->payment) }}
            </div>
        </div>
        
        <!-- Footer -->
        <div class="invoice-footer">
            Thank you for your business.
        </div>
    </div>
    
    <script>
        @if(request()->has('print'))
            window.onload = function() {
                window.print();
            };
        @endif
    </script>
    
    
    
    <script>
function downloadInvoicePDF() {
    const originalTitle = document.title;
    document.title = "Invoice-{{ $sale->order_unique_id ?? $sale->id }}";
    
    window.print();

    setTimeout(() => {
        document.title = originalTitle;
    }, 1000);
}
</script>

    
</body>
</html>