@extends('companyAdmin.layouts.master')

@section('main-content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Subscriptions</h4>
        <a href="{{ route('subscriptions.create') }}" class="btn btn-primary btn-sm">
            + Add Subscription
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">

            <!-- Desktop Table -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptions as $sub)
                        <tr>
                            <td>{{ $sub->title }}</td>
                            <td class="text-capitalize">{{ $sub->type }}</td>
                            <td>{{ $sub->price }}</td>
                            <td>{{ $sub->duration }}</td>
                            <td>
                                <a href="{{ route('subscriptions.edit',$sub->id) }}"
                                   class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                @foreach($subscriptions as $sub)
                <div class="border-bottom p-3">
                    <p><strong>{{ $sub->title }}</strong></p>
                    <p>Type: {{ ucfirst($sub->type) }}</p>
                    <p>Price: {{ $sub->price }}</p>
                    <p>Duration: {{ $sub->duration }}</p>

                    <a href="{{ route('subscriptions.edit',$sub->id) }}"
                       class="btn btn-warning btn-sm w-100">
                        Edit
                    </a>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    <div class="mt-3">
        {{ $subscriptions->links() }}
    </div>

</div>
@endsection
