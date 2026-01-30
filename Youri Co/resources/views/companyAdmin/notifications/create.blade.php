@extends('companyAdmin.layouts.master')

@section('main-content')
<div class="card p-4 shadow-sm">
    <h4 class="mb-3">Send Notification to Customers</h4>

    <form action="{{ route('notifications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Select Customers</label>
            <select name="customers[]" class="form-control" multiple required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Reminder Date</label>
            <input type="date" name="reminder_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Attach Document (optional)</label>
            <input type="file" name="attachment" class="form-control">
        </div>

        <div class="mb-3">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Notification</button>
    </form>
</div>
@endsection
