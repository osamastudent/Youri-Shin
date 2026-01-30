@extends('companyAdmin.layouts.master')

@section('page-title')
    Sales
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Sales Edit</h3>
                            <hr>
                            <div class="row p-t-20">
                                <!-- Date Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control" value="{{$sale->date}}">

                                        @error('date')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Note Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Note</label>
                                        <input type="text" name="note" id="note" class="form-control" value="{{$sale->note}}">
                                        @error('note')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Customer Field -->
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Customer</label>
                                        <select name="customer_id" id="customer_id" class="form-control">
                                            @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                         @endforeach
                                             </select>

                                        @error('customer_id')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Payment Type Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Payment Type</label>
                                        <div class="d-flex">
                                            <div class="form-check me-3">
                                                
                                                <input type="radio" name="payment" id="payment_cash" value="cash" class="form-check-input" onchange="togglePaymentFields()">
                                                <label class="form-check-label" for="payment_cash">Cash</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input type="radio" name="payment" id="payment_credit" value="credit" class="form-check-input" onchange="togglePaymentFields()">
                                                <label class="form-check-label" for="payment_credit">Credit</label>
                                            </div>
                                            <div class="form-check">
                                                
                                                <input type="radio" name="payment" id="payment_bank" value="bank" class="form-check-input" onchange="togglePaymentFields()">
                                                <label class="form-check-label" for="payment_bank">Bank</label>
                                            </div>
                                        </div>
                                        @error('payment')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Cash Fields -->
                                    <div id="cashFields" style="display: none;">
                                        <div class="form-group">
                                            <label for="cash_collected">Cash Collected</label>
                                            <input type="number" name="cash_collected" id="cash_collected" class="form-control" value="{{$sale->cash_collected}}">
                                     @error('cash_collected')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cash_received">Cash Received</label>
                                            <input type="number" name="cash_received" id="cash_received" class="form-control" value="{{$sale->cash_received}}">
                                             @error('cash_received')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="balance">Balance</label>
                                            <input type="number" name="balance" id="balance" class="form-control" value="{{$sale->balance}}">
                                               @error('balance')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                    </div>

                                    <!-- Bank Fields -->
                                    <div id="bankFields" style="display: none;">
                                        <div class="form-group">
                                            <label for="bank_account">Select Bank Account</label>
                                            <select name="bank_account" id="bank_account" class="form-control">
                                                <!-- Bank account options -->
                                                <option value="">{{$sale->bank_account}}</option>
                                                <option value="bank1">Bank 1</option>
                                                <option value="bank2">Bank 2</option>
                                            </select>
                                               @error('bank_account')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="transaction_id">Transaction ID (optional)</label>
                                            <input type="text" name="transaction_id" id="transaction_id" class="form-control" value="{{$sale->transaction_id}}">
                                              @error('transaction_id')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="transaction_date">Transaction Date (optional)</label>
                                            <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{$sale->transaction_date}}">
                                               @error('transaction_date')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="receive_amount">Receive Amount</label>
                                            <input type="number" name="receive_amount" id="receive_amount" class="form-control" value="{{$sale->receive_amount}}">
                                               @error('receive_amount')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
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
                            <button type="submit" class="btn btn-primary"  >
                                Edit
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('cash_received').addEventListener('input', function() {
        // Jab cash_received input field mein kuch type kiya jata hai
        var receivedValue = this.value; // cash_received field ki value le lo
        // cash_collected field mein receivedValue set kar do
        document.getElementById('cash_collected').value = receivedValue;
    });
</script>

<script>
function togglePaymentFields() {
    var paymentValue = document.querySelector('input[name="payment"]:checked').value;
    
    var cashFields = document.getElementById('cashFields');
    var bankFields = document.getElementById('bankFields');
    
    if (paymentValue === 'cash') {
        // Show cash fields and hide bank fields
        cashFields.style.display = 'block';
        bankFields.style.display = 'none';
    } else if (paymentValue === 'bank') {
        // Show bank fields and hide cash fields
        cashFields.style.display = 'none';
        bankFields.style.display = 'block';
    } else {
        // Hide both cash and bank fields
        cashFields.style.display = 'none';
        bankFields.style.display = 'none';
    }
}
</script>
<script>
// Function to toggle the display of cash and bank fields based on payment method
function togglePaymentFields() {
    var paymentCash = document.getElementById('payment_cash');
    var paymentCredit = document.getElementById('payment_credit');
    var paymentBank = document.getElementById('payment_bank');
    
    var cashFields = document.getElementById('cashFields');
    var bankFields = document.getElementById('bankFields');
    
    // Show or hide fields based on selected payment type
    if (paymentCash.checked) {
        cashFields.style.display = 'block';
        bankFields.style.display = 'none';
    } else if (paymentBank.checked) {
        cashFields.style.display = 'none';
        bankFields.style.display = 'block';
    } else {
        cashFields.style.display = 'none';
        bankFields.style.display = 'none';
    }
}

// Function to clear the form fields
function clearForm() {
    document.getElementById('formCreate').reset();
    // Hide all fields (cash and bank)
    document.getElementById('cashFields').style.display = 'none';
    document.getElementById('bankFields').style.display = 'none';
}



// Attach event listener to the Post button
document.getElementById('postButton').addEventListener('click', showPostAlert);

// Example print function (modify as needed)
function printFunction() {
    // Logic for printing
    window.print();
}

</script>

<!-- Include Sweet Alert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
