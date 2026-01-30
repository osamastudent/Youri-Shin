@extends('companyAdmin.layouts.master')

@section('main-content')
<div class="container">

    <h4>Edit Subscription</h4>

    <form method="POST" action="{{ route('subscriptions.update',$subscription->id) }}">
        @csrf
        @method('PUT')

        @include('companyAdmin.subscriptions.partials.form')

        <button class="btn btn-primary w-100">Update</button>
    </form>

</div>
@endsection
