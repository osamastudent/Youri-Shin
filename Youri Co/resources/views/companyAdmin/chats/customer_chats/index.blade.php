@extends('companyAdmin.layouts.master')

@section('page-title')
Customer Chat
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Chat With Customers</h3>
            <ul class="list-group">
                @foreach($customers as $customer)
                    <li class="list-group-item">
                        <a href="{{ route('customer-chat.show', ['id' => $customer->id]) }}" class="staff-link">
                            {{ $customer->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
