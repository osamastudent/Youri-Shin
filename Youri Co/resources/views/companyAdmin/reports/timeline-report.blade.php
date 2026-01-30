@extends('companyAdmin.layouts.master')
@section('page-title')
    Timeline Report
@endsection
@section('main-content')
   <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">Order Timeline Report</h3>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="sale_id" id="sale_id" class="form-control select2" style="width: 300px; height: 40px;">
                                    <option value="">Select Order No</option>
                                    @foreach ($orders as $order)
                                        <option value="{{ $order->id }}">#{{ $order->id }}</option>
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
                                    <th>Ordered</th>
                                    <th>Assigned</th>
                                    <th>In Process</th>
                                    <th>Dispatched</th>
                                    <th>Delivered</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody id="order-details-body">
                                <!-- This is where the order details will be inserted -->
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
        $('#findBtn').click(function() {
            var saleId = $('#sale_id').val();
            if (saleId) {
                $.ajax({
                    url: '{{ route('company.timeline-reports.order') }}',
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        sale_id: saleId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.order) {
                            var order = response.order;
                            var userId = '{{ Auth::user()->id }}'; // Get the authenticated user's ID

                            var orderLink = '{{ route("company-sale.show", ["user_id" => ":user_id", "id" => ":id"]) }}';
                            orderLink = orderLink.replace(':user_id', userId);
                            orderLink = orderLink.replace(':id', order.id);

                            var orderDetails = '<tr>' +
                                '<td><a href="' + orderLink + '">#' + order.id + '</a></td>' +
                                '<td>' + order.customer + '</td>' +
                                '<td>' + formatDate(order.created_at) + '</td>' +
                                '<td>' + formatDate(order.assigned_at, "Not Assigned Yet") + '</td>' +
                                '<td>' + formatDate(order.process_at, "Not Processed Yet") + '</td>' +
                                '<td>' + formatDate(order.dispatched_at, "Not Dispatched Yet") + '</td>' +
                                '<td>' + formatDate(order.delivered_at, "Not Delivered Yet") + '</td>' +
                                '</tr>';

                            function formatDate(timestamp, defaultMessage) {
                                if (timestamp === null) {
                                    return defaultMessage;
                                }
                                var date = new Date(timestamp);
                                var formattedDate = date.toLocaleString(); 
                                return formattedDate;
                            }

                            $('#order-details-body').html(orderDetails);
                            $('#order-details-table').slideDown(); 
                        } else {
                            $('#order-details-body').html('<tr><td colspan="7">Order not found</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#order-details-body').html('<tr><td colspan="7">Error fetching order details. Please try again.</td></tr>');
                    }
                });
            } else {
                $('#order-details-body').html('<tr><td colspan="7">Please select an order</td></tr>');
            }
        });
    });
</script>



@endsection
