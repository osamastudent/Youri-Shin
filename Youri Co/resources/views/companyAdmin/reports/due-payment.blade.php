@extends('companyAdmin.layouts.master')
@section('page-title')
    Due Payment Report
@endsection
@section('main-content')
   <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">Due Payment Report</h3>
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
</div>

<script>
    $(document).ready(function() {
        var userId = '{{ Auth::user()->id }}'; // Current authenticated user ID

        // Find button click event
        $('#findBtn').click(function() {
            var customerId = $('#customer_id').val(); // Get selected customer ID

            // Check if a customer is selected
            if (customerId) {
                console.log('Selected Customer ID:', customerId); // Debugging log

                // AJAX request to fetch order details
                $.ajax({
                    url: '{{ route('company.due-payment-reports.payment') }}', // API endpoint
                    type: 'GET', // HTTP method
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token
                        customer_id: customerId // Selected customer ID
                    },
                    dataType: 'json', // Expected response format
                    success: function(response) {
                        console.log('API Response:', response); // Debugging log

                        // Check if orders are available in the response
                        if (response && response.orders.length > 0) {
                            var orders = response.orders; // Orders array
                            var orderDetails = '';
                            var totalAmount = 0;
                            var totalReceived = 0;
                            var totalDue = 0;

                            // Iterate through orders to create table rows
                            orders.forEach(function(order) {
                                // Build order link dynamically
                                var orderLink = '{{ route("company-sale.show", ["user_id" => ":user_id", "id" => ":id"]) }}';
                                orderLink = orderLink.replace(':user_id', userId);
                                orderLink = orderLink.replace(':id', order.id);

                                // Append table row for the order
                                orderDetails += '<tr>' +
                                    '<td><a href="' + orderLink + '">#' + order.id + '</a></td>' +
                                    '<td>' + (order.customer || 'N/A') + '</td>' +
                                    '<td>Rs: ' + (order.total_amount || 0) + '/=</td>' +
                                    '<td>Rs: ' + (order.cash_received || 0) + '/=</td>' +
                                    '<td>Rs: ' + (order.balance || 0) + '/=</td>' +
                                    '</tr>';

                                // Calculate totals
                                totalAmount += parseFloat(order.total_amount || 0);
                                totalReceived += parseFloat(order.cash_received || 0);
                                totalDue += parseFloat(order.balance || 0);
                            });

                            // Update table with order details
                            $('#order-details-body').html(orderDetails);
                            $('#total-amount').text('Rs: ' + totalAmount.toFixed(2) + '/=');
                            $('#total-received').text('Rs: ' + totalReceived.toFixed(2) + '/=');
                            $('#total-due').text('Rs: ' + totalDue.toFixed(2) + '/=');
                            $('#order-details-table').slideDown(); // Show table
                        } else {
                            console.log('No orders found for the selected customer.'); // Debugging log
                            $('#order-details-body').html('<tr><td colspan="5">No orders found for this customer</td></tr>');
                            $('#order-details-table').slideDown(); // Show table with no data
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching orders:', xhr.responseText); // Debugging log
                        $('#order-details-body').html('<tr><td colspan="5">Error fetching order details. Please try again.</td></tr>');
                        $('#order-details-table').slideDown(); // Show error message in table
                    }
                });
            } else {
                console.warn('No customer selected.'); // Debugging log
                $('#order-details-body').html('<tr><td colspan="5">Please select a customer</td></tr>');
                $('#order-details-table').slideDown(); // Show table with warning
            }
        });
    });
</script>

@endsection
