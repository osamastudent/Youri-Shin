@extends('companyAdmin.layouts.master')

@section('page-title')
    Tax Compliance
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-tax_compliance.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Tax Compliance Info</h3>
                            <hr>
                            <div class="row p-t-20">
                                <!-- Date Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tax Amount</label>
                                        <input type="text" name="tax_amount" id="tax_amount" class="form-control @error('tax_amount') is-invalid @enderror">
                                        @error('tax_amount')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tax Rate</label>
                                        <input type="text" name="tax_rate" id="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror">
                                        @error('tax_rate')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tax Type</label>
                                    <select name="tax_type" id="tax_type" class="form-control @error('tax_type') is-invalid @enderror">
                                        <option value="">Select Tax Type</option>
                                        <option value="sales tax" {{ old('tax_type') == 'sales tax' ? 'selected' : '' }}>Sales Tax</option>
                                        <option value="income tax" {{ old('tax_type') == 'income tax' ? 'selected' : '' }}>Income Tax</option>
                                    </select>
                                    @error('tax_type')
                                        <small class="form-control-feedback text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Total Value</label>
                                        <input type="text" name="total_value" id="total_value" class="form-control @error('total_value') is-invalid @enderror">
                                        @error('total_value')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Payment Date</label>
                                        <input type="date" name="payment_date" id="payment_date" class="form-control @error('payment_date') is-invalid @enderror">
                                        @error('payment_date')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Filing Status</label>
                                        <input type="text" name="filing_status" id="filing_status" class="form-control @error('filing_status') is-invalid @enderror">
                                        @error('filing_status')
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
