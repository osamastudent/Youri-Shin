@extends('deactivate.layouts.master')

@section('page-title')
   Deactivate Customer Account
@endsection

@section('main-content')
<style>/* Optional: Adjust the width of the input fields */
input.form-control {
    width: 100%;   /* Make sure it takes full width within its grid */
    max-width: 400px;  /* Set a maximum width (adjust as needed) */
}
</style>
    <!-- Wrapper div with white background and styling -->
    <div class="bg-white p-4 shadow-sm rounded">
        <form action="{{ route('admin.deactivate.submit') }}"  method="POST">
            @csrf
            <div class="form-group row">
                <label for="email" class="col-md-1 col-form-label">Email</label>
                <!-- Set col-md-6 or adjust as necessary for left-aligned input -->
                <div class="col-md-6">
                    <input type="email" id="email" name="email" class="form-control"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-1 col-form-label">Password</label>
                <!-- Set col-md-6 or adjust as necessary for left-aligned input -->
                <div class="col-md-6">
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Deactivate This User ?')">Deactivate</button>
        </form>
    </div>
    

@endsection
