@extends('companyAdmin.layouts.master')
@section('page-title')
    Water Bottles Report
@endsection
@section('main-content')
   <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb3">
                        <h3 class="card-title">19L Empty bottles Report</h3>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="customer_id" id="customer_id" class="form-control select2" style="width: 300px; height: 40px;">
                                    <option value="">Select Customers</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mx-3">
                                <button id="findBtn" class="btn btn-sm btn-primary">Find</button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card" id="order-details-table" style="display: none;">
                <div class="card-body">
                    <h3 class="card-title">Order Details</h3>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Customer Name</th>
                                    <th>Bottles Sent</th>
                                    <th>Bottles Received</th>
                                    <th>Total Amount</th>
                                    <th>Amount Received</th>
                                    <th>Due Amount</th>
                                </tr>
                            </thead>
                            <tbody id="order-details-body">
                                <!-- This is where the order details will be inserted -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th id="total-bottles-sent">0</th>
                                    <th id="total-bottles-received">0</th>
                                    <th id="total-amount">0</th>
                                    <th id="total-received">0</th>
                                    <th id="total-due">0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card" id="stock-table" style="display: none;">
                <div class="card-body">
                    <h3 class="card-title">Bottles on Customer End<span id="stock-summary-value"></span></h3>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Opening Stock</th>
                                    <td><input type="number" id="opening-stock" class="form-control" disabled></td>
                                </tr>
                                <tr>
                                    <th>Bottles Sent</th>
                                    <td><input type="number" id="total-bottles-sent-input" class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <th>Bottles Received</th>
                                    <td><input type="number" id="total-bottles-received-input" class="form-control" readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var userId = '{{ Auth::user()->id }}';

        $('#findBtn').click(function() {
            var customerId = $('#customer_id').val();

            if (!customerId) {
                $('#order-details-body').html('<tr><td colspan="7">Please select a customer</td></tr>');
                clearTotals();
                $('#order-details-table').slideDown();
                $('#stock-table').slideUp();
                return;
            }

            // Show loading state
            $('#order-details-body').html('<tr><td colspan="7">Loading...</td></tr>');

            $.ajax({
                url: '{{ route('company.bottles-reports.bottles') }}',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    customer_id: customerId
                },
                dataType: 'json',
                success: function(response) {
                    console.log('API Response:', response); // Debug log
                    
                    if (response && response.orders && response.orders.length > 0) {
                        var orders = response.orders;
                        var orderDetails = '';
                        var totalBottlesSent = 0;
                        var totalBottlesReceived = 0;
                        var totalAmount = 0;
                        var totalReceived = 0;
                        var totalDue = 0;
                        var openingStock = parseInt(orders[0].opening_stock) || 0;

                        orders.forEach(function(order) {
                            console.log('Processing order:', order); // Debug log
                            
                            var orderLink = '{{ route("company-sale.show", ["user_id" => ":user_id", "id" => ":id"]) }}';
                            orderLink = orderLink.replace(':user_id', userId);
                            orderLink = orderLink.replace(':id', order.id);

                            // Use safe access with fallbacks
                            var bottleSent = parseFloat(order.bottle_sent) || 0;
                            var bottleReceived = parseFloat(order.bottle_recieved) || 0;
                            var totalAmountVal = parseFloat(order.total_amount) || 0;
                            var cashReceived = parseFloat(order.cash_received) || 0;
                            var balance = parseFloat(order.balance) || 0;

                            orderDetails += '<tr>' +
                                '<td><a href="' + orderLink + '">#' + order.id + '</a></td>' +
                                '<td>' + (order.customer || 'N/A') + '</td>' +
                                '<td>' + bottleSent + '</td>' +
                                '<td>' + bottleReceived + '</td>' +
                                '<td>Rs: ' + totalAmountVal.toFixed(2) + '/=</td>' +
                                '<td>Rs: ' + cashReceived.toFixed(2) + '/=</td>' +
                                '<td>Rs: ' + balance.toFixed(2) + '/=</td>' +
                                '</tr>';

                            totalBottlesSent += bottleSent;
                            totalBottlesReceived += bottleReceived;
                            totalAmount += totalAmountVal;
                            totalReceived += cashReceived;
                            totalDue += balance;
                        });

                        var stockSummary = openingStock + totalBottlesSent - totalBottlesReceived;

                        $('#order-details-body').html(orderDetails);
                        $('#total-bottles-sent').text(totalBottlesSent);
                        $('#total-bottles-received').text(totalBottlesReceived);
                        $('#total-amount').text('Rs: ' + totalAmount.toFixed(2) + '/=');
                        $('#total-received').text('Rs: ' + totalReceived.toFixed(2) + '/=');
                        $('#total-due').text('Rs: ' + totalDue.toFixed(2) + '/=');
                        $('#opening-stock').val(openingStock).prop('disabled', true);
                        $('#total-bottles-sent-input').val(totalBottlesSent);
                        $('#total-bottles-received-input').val(totalBottlesReceived); 

                        $('#stock-summary-value').text('(' + stockSummary + ')');

                        $('#order-details-table').slideDown();
                        $('#stock-table').slideDown();
                    } else {
                        var message = response && response.message ? response.message : 'No orders found for this customer';
                        $('#order-details-body').html('<tr><td colspan="7">' + message + '</td></tr>');
                        clearTotals();
                        $('#order-details-table').slideDown();
                        $('#stock-table').slideUp();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    var errorMessage = 'Error fetching order details. Please try again.';
                    
                    // Try to get more specific error message
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    $('#order-details-body').html('<tr><td colspan="7">' + errorMessage + '</td></tr>');
                    clearTotals();
                    $('#order-details-table').slideDown();
                    $('#stock-table').slideUp();
                }
            });
        });

        function clearTotals() {
            $('#total-bottles-sent').text('');
            $('#total-bottles-received').text('');
            $('#total-amount').text('');
            $('#total-received').text('');
            $('#total-due').text('');
        }
    });
</script>
@endsection
