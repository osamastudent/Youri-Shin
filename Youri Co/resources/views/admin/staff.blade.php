@extends('deactivate.layouts.master')

@section('page-title')
   Deactivate Customer Account
@endsection

@section('main-content')
<style>
/* Optional: Adjust the width of the input fields */
input.form-control {
    width: 100%;   /* Make sure it takes full width within its grid */
    max-width: 400px;  /* Set a maximum width (adjust as needed) */
}
</style>

<!-- Wrapper div with white background and styling -->
<div class="bg-white p-4 shadow-sm rounded">
    <form action="{{ route('staff.deactivate.submit') }}" method="POST">
        @csrf
        <div class="form-group row">
            <!-- Email Label and Input -->
            <label for="email" class="col-md-2 col-form-label">Email</label>
            <!-- Adjusting the column width for the input field -->
            <div class="col-md-8">
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter customer email" required>
            </div>
        </div>
        <div class="form-group row">
            <!-- Password Label and Input -->
            <label for="password" class="col-md-2 col-form-label">Password</label>
            <!-- Adjusting the column width for the input field -->
            <div class="col-md-8">
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter customer password" required>
            </div>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-danger mt-3" onclick="return confirm('Are You Sure You Want To Deactivate This User ?')">Deactivate</button>
    </form>
</div>

@endsection
