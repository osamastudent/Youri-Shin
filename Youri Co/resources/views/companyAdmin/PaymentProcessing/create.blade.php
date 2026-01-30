@extends('companyAdmin.layouts.master')

@section('page-title')
Payment Proccessing
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-payment_processing.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Payment Proccessing Info</h3>
                            <hr>
                            <div class="row p-t-20">

                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Payment Date</label>
                                        <input type="date" name="payment_date" id="payment_date" class="form-control @error('payment_date') is-invalid @enderror">
                                        @error('payment_date')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                
                                
                                
                           <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror">
                                <option value="">Select Payment Method</option>
                                <option value="credit card" {{ old('payment_method') == 'credit card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="bank transfer" {{ old('payment_method') == 'bank transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                            @error('payment_method')
                                <small class="form-control-feedback text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Payment Amount</label>
                                <input type="text" name="payment_amount" id="payment_amount" class="form-control @error('payment_amount') is-invalid @enderror">
                                @error('payment_amount')
                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>



                               
                              <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror">
                                    <option value="">Select Payment Status</option>
                                    <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('payment_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('payment_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('payment_status')
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
