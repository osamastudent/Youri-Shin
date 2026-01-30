@extends('companyAdmin.layouts.master')

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                
                    <h2 class="mb-4">All Subscriptions</h2>

                        <div class="table-responsive m-t-40">
                        <table id="table1" class="display nowrap table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Frequency</th>
                                    <th>Day of Week</th>
                                    <th>Day of Month</th>
                                    <th>Time Start</th>
                                    <th>Time End</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subscriptions as $key => $sub)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $sub->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $sub->item->name ?? 'N/A' }}</td>
                                        <td>{{ $sub->buying_quantity }}</td>
                                        <td>{{ ucfirst($sub->frequency) }}</td>
                                        <td>{{ $sub->day_of_week ?? '-' }}</td>
                                        <td>{{ $sub->day_of_month ?? '-' }}</td>
                                        <td>{{ $sub->time_start ?? '-' }}</td>
                                        <td>{{ $sub->time_end ?? '-' }}</td>
                                        <td>{{$sub->status}}</td>     
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-muted py-3">
                                            No subscriptions found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
