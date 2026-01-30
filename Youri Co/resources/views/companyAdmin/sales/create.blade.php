@extends('companyAdmin.layouts.master')

@section('page-title')
  Add Sales
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                  <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-sale.store') }}" enctype="multipart/form-data">
    @csrf
  
  
  <div class="form-body">
    <h3 class="card-title">Add Sales</h3>
    <hr>
    <div class="row p-t-20">

        <!-- Customer Field -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label d-block">Customer</label>
                <div class="d-flex align-items-center">
                    <select name="customer_id" id="customer_id" class="form-control" style="width: 66%; margin-right: 10px;">
                        <option value="">Select a customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->phone_number }})
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary btn-sm ml-3" data-toggle="modal" data-target="#addCustomerModal">
                        <i class="fa fa-plus"></i> Add New
                    </button>
                </div>
                @error('customer_id')
                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <!-- Items Field -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Items</label><br>
                <select name="item_id" id="item_id" class="form-control" style="width:420px;">
                    <option value="">Select an Item</option>
                    @foreach ($items as $item)
                        @php
                            $selected = false;
                            if (old('item_id') == $item->id) {
                                $selected = true;
                            }
                        @endphp
                        <option value="{{ $item->id }}" data-sale-price="{{ $item->sale_price }}" {{ $selected ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
                @error('item_id')
                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <!-- Note Field -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label d-block">Note</label>
                <input type="text" name="note" id="note" class="form-control" value="{{ old('note') }}" style="width: 66%;">
                @error('note')
                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
</div>

    <div class="col-md-4">
        <div class="md-3">
            <label for="example-text-input" class="form-label" style="margin-top: 43px;"></label>
            <i class="btn btn-secondary btn-rounded waves-effect waves-light fa fa-plus-circle addeventmore"> Add Items</i>
        </div>
    </div><br><br>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="addRow">
            <!-- New rows will be appended here -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong></strong></td>
                <td>
                    <input type="text" name="total_amount" id="total_amount" class="form-control text-right" value="{{ old('total_amount', '0') }}" readonly>
                </td>
                <!--<td></td>-->
            </tr>
        </tfoot>
    </table>
    
    <!-- Payment Type Field -->
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Payment Type</label>
            <div class="d-flex">
                <div class="form-check mx-3">
                    <input type="radio" name="payment" id="payment_credit" value="credit" class="form-check-input" onchange="togglePaymentFields()" {{ old('payment', 'credit') == 'credit' ? 'checked' : '' }}>
                    <label class="form-check-label" for="payment_credit">Credit</label>
                </div>
                <div class="form-check mx-3">
                    <input type="radio" name="payment" id="payment_cash" value="cash" class="form-check-input" onchange="togglePaymentFields()" {{ old('payment') == 'cash' ? 'checked' : '' }}>
                    <label class="form-check-label" for="payment_cash">Cash</label>
                </div>
            </div>
            @error('payment')
                <small class="form-control-feedback text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    
    <!-- Cash Fields -->
    <div id="cashFields" style="display: {{ old('payment') == 'cash' ? 'block' : 'none' }};">
        <div class="form-group">
            <label for="cash_received">Cash Received</label>
            <input type="number" name="cash_received" id="cash_received" class="form-control" value="{{ old('cash_received', 0) }}">
            @error('cash_received')
                <small class="form-control-feedback text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="balance">Balance</label>
            <input type="number" name="balance" id="balance" class="form-control" value="{{ old('balance', 0) }}" readonly>
            @error('balance')
                <small class="form-control-feedback text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <!-- Buttons -->
    <div class="form-actions mt-5">
        <!-- Clear Button -->
        <a href="/company/sale" class="btn btn-secondary" onclick="clearForm()">
            Clear
        </a>

        <!-- Post Button -->
        <button type="submit" class="btn btn-primary" id="postButton">
            Save
        </button>
    </div>
</form>



<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="qrCodeModalLabel">Order QR Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                @if(session('sale_id'))
                    @php
                        $sale = \App\Models\Sales::find(session('sale_id'));
                    @endphp
                    @if($sale && $sale->qr_code_path)
                        <div id="qrCodeContainer">
                            <img src="{{ asset($sale->qr_code_path) }}" alt="QR Code" 
                                 style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 10px;">
                        </div>
                        
                        <div class="mt-3 order-info">
                            <h5>Order Information</h5>
                            <p><strong>Order ID:</strong> {{ $sale->order_unique_id ?? $sale->id }}</p>
                            <p><strong>Total Amount:</strong> ${{ number_format($sale->total_amount, 2) }}</p>
                            <p><strong>Status:</strong> 
                                @if($sale->status == 0)
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($sale->status == 1)
                                    <span class="badge badge-success">Completed</span>
                                @else
                                    <span class="badge badge-secondary">Unknown</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="mt-4">
                            <button onclick="downloadQRCode('{{ $sale->id }}')" class="btn btn-primary">
                                <i class="fa fa-download"></i> Download QR Code
                            </button>
                            <button onclick="printQRCode()" class="btn btn-secondary">
                                <i class="fa fa-print"></i> Print QR Code
                            </button>
                            <a href="{{ route('sale.qrcode.view', $sale->id) }}" class="btn btn-info" target="_blank">
                                <i class="fa fa-eye"></i> View Details
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            No QR Code available for this order.
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bg-primary p-2 text-white" id="addCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="customerForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Name *</label>
                                <input type="text" name="name" id="modal_name" class="form-control" required>
                                <span class="text-danger" id="name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Address *</label>
                                <input type="text" name="address" id="modal_address" class="form-control" required>
                                <span class="text-danger" id="address_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Zone *</label>
                                <select name="zone_id" id="modal_zone_id" class="form-control" required>
                                    <option value="">Select a Zone</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="zone_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Phone Number *</label>
                                <input type="text" name="phone_number" id="modal_phone_number" class="form-control" required>
                                <span class="text-danger" id="phone_number_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">ID Card Number *</label>
                                <input type="text" name="id_card_no" id="modal_id_card_no" class="form-control" required>
                                <span class="text-danger" id="id_card_no_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Category *</label>
                                <select name="category" id="modal_category" class="form-control" required>
                                    <option value="">Select a Category</option>
                                    <option value="Domestic">Domestic</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Corporate">Corporate</option>
                                </select>
                                <span class="text-danger" id="category_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Opening Balance *</label>
                                <input type="number" name="opening_balance" id="modal_opening_balance" class="form-control" required>
                                <span class="text-danger" id="opening_balance_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Opening Stock *</label>
                                <input type="number" name="opening_stock" id="modal_opening_stock" class="form-control" required>
                                <span class="text-danger" id="opening_stock_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Profile Image</label>
                                <input type="file" name="profile_image" id="modal_profile_image" class="form-control">
                                <span class="text-danger" id="profile_image_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Email *</label>
                                <input type="email" name="email" id="modal_email" class="form-control" required>
                                <span class="text-danger" id="email_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Password *</label>
                                <input type="password" name="password" id="modal_password" class="form-control" required>
                                <span class="text-danger" id="password_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Confirm Password *</label>
                                <input type="password" name="confirm_password" id="modal_confirm_password" class="form-control" required>
                                <span class="text-danger" id="confirm_password_error"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveCustomerBtn">
                    <i class="fa fa-check"></i> Save Customer
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    // Show QR Code modal if session has flag
    @if(session('show_qr_modal'))
        $(document).ready(function() {
            $('#qrCodeModal').modal('show');
        });
    @endif

    function downloadQRCode(saleId) {
        window.location.href = '/company/sale/' + saleId + '/download-qrcode';
    }

    function printQRCode() {
        const printContent = document.getElementById('qrCodeContainer').innerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
</script>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Handlebars template -->
<script id="document-template" type="text/x-handlebars-template">
    <tr class="delete_add_more_item" id="delete_add_more_item">
        <td>
            <input type="hidden" name="customer_id" value="@{{customer_id}}">
            @{{customer_name}}
        </td>
        <td>
            <input type="hidden" name="item_id[]" value="@{{item_id}}">
            @{{item_name}}
        </td>
        <td>
            <input type="number" name="buying_qty[]" min="1" class="form-control buying_qty">
        </td>
        <td>
            <input type="number" name="bottles[]" class="form-control bottles" value="@{{bottles}}" readonly>
        </td>

        <td>
            <input type="number" name="unit_price[]" class="form-control unit_price" value="@{{unit_price}}.0" readonly>
        </td>
        <td>
            <input type="number" name="buying_price[]" class="form-control buying_price text-right" value="0" readonly>
        </td>
        <td>
            <i class="btn btn-danger btn-sm fa fa-window-close removeeventmore"></i>
        </td>
    </tr>
</script>

<!-- Handlebars CDN -->
<script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        var itemSalePrice = {};
    
        // Store sale prices for items
        $('#item_id option').each(function(){
            var itemId = $(this).val();
            var salePrice = $(this).data('sale-price');
            itemSalePrice[itemId] = salePrice;
        });
    
        // Add event handler
        $(document).on("click", ".addeventmore", function(){
            var customer_id = $('#customer_id').val();
            var customer_name = $('#customer_id').find('option:selected').text();
            var item_id = $('#item_id').val();
            var item_name = $('#item_id').find('option:selected').text();
            var unit_price = itemSalePrice[item_id];
           // In the addeventmore click handler:
var bottles = $('#initial_bottles').val(); // Changed from $('#bottles').val()
    
            // Ensure customer and item are selected
            if (customer_id == '') {
                toastr.error('Please select a customer first!');
                return;
            }
    
            if (item_id == '') {
                toastr.error('Please select an item first!');
                return;
            }
    
            // Get the Handlebars template
            var source = $("#document-template").html();
            var template = Handlebars.compile(source);
    
            // Prepare the data for the template
            var data = {
                customer_id: customer_id,
                customer_name: customer_name,
                item_id: item_id,
                item_name: item_name,
                unit_price: unit_price,
               
            }
            // Generate the HTML
            var html = template(data);
    
            // Append the generated HTML to the table
            $("#addRow").append(html);
    
            // Disable customer selection
            $('#customer_id').prop('disabled', true);
        });
    
        // Remove event handler
        $(document).on("click", ".removeeventmore", function(event){
            $(this).closest('.delete_add_more_item').remove();
            totalAmountPrice();
    
            // Enable customer selection if no items are left
            if ($('#addRow').children().length === 0) {
                $('#customer_id').prop('disabled', false);
            }
        });
    
        // Update buying price
        $(document).on('keyup click', '.unit_price, .buying_qty', function(){
            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var qty = $(this).closest("tr").find("input.buying_qty").val();
            var total = (unit_price * qty).toFixed(2); // ensure two decimal places
            $(this).closest("tr").find("input.buying_price").val(total);
            totalAmountPrice();
        });
    
        // Calculate total amount
        function totalAmountPrice(){
            var sum = 0;
            $(".buying_price").each(function(){
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }   
            });
            $('#total_amount').val(sum.toFixed(2)); // ensure two decimal places
        }
    
        // Update balance based on cash received
        $(document).on('keyup', '#cash_received', function(){
            var totalAmount = parseFloat($('#total_amount').val());
            var cashReceived = parseFloat($(this).val());
            var balance = totalAmount - cashReceived;
            $('#balance').val(balance.toFixed(2)); // ensure two decimal places
        });
    });
    
    // Show/hide payment fields based on selected payment type
    function togglePaymentFields() {
        var paymentType = $('input[name="payment"]:checked').val();
    
        if (paymentType === 'cash') {
            $('#cashFields').slideDown();
            $('#bankFields').slideUp();
        } else if (paymentType === 'bank') {
            $('#cashFields').slideUp();
            $('#bankFields').slideDown();
        } else {
            $('#cashFields').slideUp();
            $('#bankFields').slideUp();
        }
    }
    
    // Clear form function
    function clearForm() {
        document.getElementById("formCreate").reset();
        $('#total_amount').val('');
        $('#addRow').empty();
        $('#balance').val('');
        $('#customer_id').prop('disabled', false); // Enable customer selection on form reset
    }
</script>
<script>
$(document).ready(function() {
    // Handle customer form submission via AJAX
    $('#saveCustomerBtn').click(function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('.text-danger').text('');
        
        // Show loading
        $(this).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        $(this).prop('disabled', true);
        
        // Get form data
        var formData = new FormData($('#customerForm')[0]);
        
        // Add AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Make AJAX request
        $.ajax({
            url: '{{ route("company-customer.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Reset button
                $('#saveCustomerBtn').html('<i class="fa fa-check"></i> Save Customer');
                $('#saveCustomerBtn').prop('disabled', false);
                
                if (response.success) {
                    // Show success message
                    toastr.success(response.message);
                    
                    // Add new customer to dropdown
                    var newOption = new Option(response.customer.name + ' (' + response.customer.phone_number + ')', 
                                                response.customer.id, true, true);
                    $('#customer_id').append(newOption).trigger('change');
                    
                    // Reset form
                    $('#customerForm')[0].reset();
                    
                    // Close modal
                    $('#addCustomerModal').modal('hide');
                    
                    // Focus on customer dropdown
                    $('#customer_id').focus();
                }
            },
            error: function(xhr) {
                // Reset button
                $('#saveCustomerBtn').html('<i class="fa fa-check"></i> Save Customer');
                $('#saveCustomerBtn').prop('disabled', false);
                
                if (xhr.status === 422) {
                    // Validation errors
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + '_error').text(value[0]);
                    });
                    toastr.error('Please fix the errors in the form.');
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            }
        });
    });
    
    // Clear errors when modal is closed
    $('#addCustomerModal').on('hidden.bs.modal', function () {
        $('.text-danger').text('');
        $('#customerForm')[0].reset();
    });
    
    // Optional: Auto-focus on first input when modal opens
    $('#addCustomerModal').on('shown.bs.modal', function () {
        $('#modal_name').focus();
    });
    
    // Optional: Press Enter in modal to submit
    $('#customerForm input').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#saveCustomerBtn').click();
        }
    });
});
</script>


@if(old('item_id'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // old values
        let items    = @json(old('item_id'));
        let qtys     = @json(old('buying_qty'));
        let prices   = @json(old('unit_price'));
        let totals   = @json(old('buying_price'));

        let customer = @json(old('customer_id'));

        // lookup maps for names (from controller you passed $customers, $items)
        let customers = @json($customers->pluck('name','id'));
        let itemNames = @json($items->pluck('name','id'));

        let tbody = document.getElementById("addRow");

        items.forEach((item_id, index) => {
            let tr = document.createElement("tr");
            tr.innerHTML = `
                <td>
                    <input type="hidden" name="customer_id" value="${customer}">
                    ${customers[customer] ?? ''}
                </td>
                <td>
                    <input type="hidden" name="item_id[]" value="${item_id}">
                    ${itemNames[item_id] ?? ''}
                </td>
                <td>
                    <input type="number" name="buying_qty[]" value="${qtys[index]}" class="form-control buying_qty">
                </td>
        
                <td>
                    <input type="number" name="unit_price[]" value="${prices[index]}" class="form-control unit_price" readonly>
                </td>
                <td>
                    <input type="number" name="buying_price[]" value="${totals[index]}" class="form-control buying_price text-right" readonly>
                </td>
                <td>
                    <i class="btn btn-danger btn-sm fa fa-window-close removeeventmore"></i>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // restore total
        document.getElementById("total_amount").value = 
            totals.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
    });
</script>


@endif



@endsection
