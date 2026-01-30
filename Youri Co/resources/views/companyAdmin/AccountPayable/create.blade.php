@extends('companyAdmin.layouts.master')

@section('page-title')
    Account Payable
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-account_payable.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">    Account Payable Info</h3>
                            <hr>
                            <div class="row p-t-20">
                                <!-- Date Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Invoice No</label>
                                        <input type="text" name="invoice_no" id="invoice_no" class="form-control @error('invoice_no') is-invalid @enderror">
                                        @error('invoice_no')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror">
                                        @error('date')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Supplier Name</label>
                                        <input type="text" name="supplier_name" id="supplier_name" class="form-control @error('supplier_name') is-invalid @enderror">
                                        @error('supplier_name')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Product Description</label>
                                        <input type="textarea" name="product_description" id="product_description" class="form-control">
                                        @error('product_description')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control">
                                        @error('quantity')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Unit Price</label>
                                        <input type="number" name="unit_price" id="unit_price" class="form-control">
                                        @error('unit_price')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Total Cost</label>
                                        <input type="text" name="total_cost" id="total_cost" class="form-control">
                                        @error('product_description')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Payment Date</label>
                                        <input type="text" name="payment_date" id="payment_date" class="form-control">
                                        @error('product_description')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Payment Method</label>
                                        <input type="text" name="payment_method" id="payment_method" class="form-control">
                                        @error('payment_method')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                               
                              
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-actions mt-5">
                            <!-- Clear Button -->
                            <button type="button" class="btn btn-secondary" onclick="clearForm()">
                                Clear
                            </button>

                             <!--Post Button   -->
                            <button type="submit" class="btn btn-primary" id="postButton" >
                                Post
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// // Function to handle the SweetAlert modal
// function showPostAlert() {
//     Swal.fire({
//         title: 'Post?',
//         text: 'Are you sure you want to post?',
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Confirm',
//         cancelButtonText: 'Cancel',
//         showDenyButton: true,
//         denyButtonText: 'Yes, Confirm and Print'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             // Perform the post action here
//             // For example, submit the form
//             document.getElementById('formCreate').submit();
//         } else if (result.isDenied) {
//             // Perform the post action and print here
//             document.getElementById('formCreate').submit();
//             printFunction(); // Call the print function here
//         }
//         // If cancelled, do nothing
//     });
// }

// // Attach event listener to the Post button
// document.getElementById('postButton').addEventListener('click', showPostAlert);

// // Example print function (modify as needed)
// function printFunction() {
//     // Logic for printing
//     window.print();
// }

// </script>

<!-- Include Sweet Alert script -->
<!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->
@endsection
