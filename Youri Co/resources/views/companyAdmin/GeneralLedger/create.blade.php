@extends('companyAdmin.layouts.master')

@section('page-title')
    General Ledger
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-general_ledger.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">    General Ledger Info</h3>
                            <hr>
                            <div class="row p-t-20">
                                <!-- Date Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Account No</label>
                                        <input type="text" name="account_number" id="account_number" class="form-control @error('account_number') is-invalid @enderror">
                                        @error('account_number')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Account Name</label>
                                        <input type="text" name="account_name" id="account_name" class="form-control @error('account_name') is-invalid @enderror">
                                        @error('account_name')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Credit/Dabit Amount</label>
                                        <input type="text" name="debit_credit_amount" id="debit_credit_amount" class="form-control @error('debit_credit_amount') is-invalid @enderror">
                                        @error('debit_credit_amount')
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
                                        <label class="control-label"> Description</label>
                                        <input type="text" name="description" id="description" class="form-control">
                                        @error('product_description')
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
