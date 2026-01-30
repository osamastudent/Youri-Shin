@extends('companyAdmin.layouts.master')

@section('main-content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <h4>Create Subscription</h4>
        </div>

        <form method="POST" action="{{ route('company-subscriptions.store') }}">
            @csrf

            <div class="card-body row">

                <!-- Customer -->
                <div class="col-md-6 mb-3">
                    <label>Customer</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Item -->
                <div class="col-md-6 mb-3">
                    <label>Item</label>
                    <select name="item_id" class="form-control" required>
                        <option value="">Select Item</option>
                        @foreach($items as $i)
                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div class="col-md-4 mb-3">
                    <label>Quantity</label>
                    <input type="number" name="buying_quantity" class="form-control" min="1" required>
                </div>

                <!-- Frequency -->
                <div class="col-md-4 mb-3">
                    <label>Frequency</label>
                    <select name="frequency" id="frequency" class="form-control" required>
                        <option value="">Select</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>

                <!-- Weekly -->
                <div class="col-md-4 mb-3 d-none" id="weeklyBox">
                    <label>Day of Week</label>
                    <select name="day_of_week" class="form-control">
                        <option value="">Select</option>
                        @foreach(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $day)
                            <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Monthly -->
                <div class="col-md-4 mb-3 d-none" id="monthlyBox">
                    <label>Day of Month</label>
                    <input type="number" name="day_of_month" class="form-control" min="1" max="31">
                </div>

                <!-- Time -->
                <div class="col-md-6 mb-3">
                    <label>Time Start</label>
                    <input type="time" name="time_start" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Time End</label>
                    <input type="time" name="time_end" class="form-control" required>
                </div>

                <!-- Address -->
                <div class="col-md-12 mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="2" required></textarea>
                </div>

                <!-- Notes -->
                <div class="col-md-12 mb-3">
                    <label>Notes</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>

            </div>

            <div class="card-footer text-right">
                <button class="btn btn-success">Create Subscription</button>
            </div>
        </form>
    </div>
</div>


<script>
document.getElementById('frequency').addEventListener('change', function () {
    document.getElementById('weeklyBox').classList.add('d-none');
    document.getElementById('monthlyBox').classList.add('d-none');

    if (this.value === 'weekly') {
        document.getElementById('weeklyBox').classList.remove('d-none');
    }

    if (this.value === 'monthly') {
        document.getElementById('monthlyBox').classList.remove('d-none');
    }
});
</script>
@endsection



