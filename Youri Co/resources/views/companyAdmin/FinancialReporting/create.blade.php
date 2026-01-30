@extends('companyAdmin.layouts.master')

@section('page-title')
    Financial Reporting
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-financial_reporting.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Financial Reporting Info</h3>
                            <hr>
                            <div class="row p-t-20">
                                <!-- Date Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Report Type</label>
                                    <select name="report_type" id="report_type" class="form-control @error('report_type') is-invalid @enderror">
                                        <option value="">Select Report Type</option>
                                        <option value="Balance Sheet" >Balance Sheet</option>
                                        <option value="Income Statement" >Income Statement</option>
                                        <option value="Cash Flow Statement">Cash Flow Statement</option>
                                    </select>
                                    @error('tax_type')
                                        <small class="form-control-feedback text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Report Date</label>
                                        <input type="text" name="report_date" id="report_date" class="form-control @error('report_date') is-invalid @enderror">
                                        @error('report_date')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Account Name</label>
                                        <select name="account_name" id="account_name" class="form-control @error('account_name') is-invalid @enderror">
                                            <option value="">Select Account Name</option>
                                            <option value="Cash" {{ old('account_name') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Accounts Payable" {{ old('account_name') == 'Accounts Payable' ? 'selected' : '' }}>Accounts Payable</option>
                                            <option value="Accounts Receivable" {{ old('account_name') == 'Accounts Receivable' ? 'selected' : '' }}>Accounts Receivable</option>
                                        </select>
                                        @error('account_name')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Debit / Credit Amount</label>
                                        <input type="text" name="debit_credit_amount" id="debit_credit_amount" class="form-control @error('debit_credit_amount') is-invalid @enderror">
                                        @error('debit_credit_amount')
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
