@extends('companyAdmin.layouts.master')

@section('main-content')
@if($errors->has('coupon_no'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ $errors->first('coupon_no') }}
</div>
@endif
@if(session()->has('message'))
<div class="alert alert-success alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {!! session()->get('message') !!}
</div>
@endif

<section>
    <div class="container-fluid mb-3">
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#create-modal">
            <i class="dripicons-plus"></i> {{('Add Coupon')}}
        </button>
    </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
    <div class="table-responsive">
        <table id="coupon-table" class="table" style="width:100%">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{('Coupon Code')}}</th>
                    <th>{{('Type')}}</th>
                    <th>{{('Amount')}}</th>
                    <th>{{('Minimum Amount')}}</th>
                    <th>Qty</th>
                    <th>{{('Available')}}</th>
                    <th>{{('Expired Date')}}</th>
                    <th>{{('Created By')}}</th>
                    <th class="not-exported">{{('action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_coupon_all as $key=>$coupon)
                <?php $created_by = DB::table('users')->find($coupon->user_id); ?>
                <tr data-id="{{$coupon->id}}">
                    <td>{{$key+1}}</td>
                    <td>{{ $coupon->code }}</td>
                    <td>
                        <div class="badge {{ $coupon->type == 'percentage' ? 'badge-primary' : 'badge-info' }}">
                            {{$coupon->type}}
                        </div>
                    </td>
                    <td>{{ $coupon->amount }}</td>
                    <td>{{ $coupon->minimum_amount ?? 'N/A' }}</td>
                    <td>{{ $coupon->quantity }}</td>
                    <td class="text-center">
                        <div class="badge {{ $coupon->quantity - $coupon->used > 0 ? 'badge-success' : 'badge-danger' }}">
                            {{ $coupon->quantity - $coupon->used }}
                        </div>
                    </td>
                    <td>
                        <div class="badge {{ $coupon->expired_date >= date("Y-m-d") ? 'badge-danger' : 'badge-danger' }}">
                            {{ date('d-m-Y', strtotime($coupon->expired_date)) }}
                        </div>
                    </td>
                    <td>{{ $created_by->name ?? 'N/A' }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-default btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                {{('action')}}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item edit-btn"
                                        data-id="{{ $coupon->id }}"
                                        data-code="{{ $coupon->code }}"
                                        data-type="{{ $coupon->type }}"
                                        data-amount="{{ $coupon->amount }}"
                                        data-minimum_amount="{{ $coupon->minimum_amount }}"
                                        data-quantity="{{ $coupon->quantity }}"
                                        data-expired_date="{{ $coupon->expired_date }}"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="dripicons-document-edit"></i> {{('edit')}}
                                    </button>
                                </li>
                                <li>
                                    <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" onclick="return confirmDelete()">
                                            <i class="dripicons-trash"></i> {{('delete')}}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
        </div>
    </div>
    </div>
</div>
</section>

{{-- Create Modal --}}
<div id="create-modal" class="modal fade text-left" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle mr-1"></i> Add Coupon</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('coupons.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Coupon Code *</label>
                            <div class="input-group">
                                <input type="text" name="code" id="couponCode" class="form-control" required>
                                <button type="button" class="btn btn-secondary btn-sm" id="generateCode">Generate</button>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Type *</label>
                            <select name="type" id="couponType" class="form-control" required>
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group" id="minAmountField">
                            <label>Minimum Amount *</label>
                            <input type="number" name="minimum_amount" class="form-control" step="any">
                        </div>

                        <div class="col-md-6 form-group">
                            <label id="amountLabel">Amount *</label>
                            <input type="number" name="amount" class="form-control" step="any" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Qty *</label>
                            <input type="number" name="quantity" class="form-control" step="any" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Expired Date</label>
                            <input type="date" name="expired_date" class="form-control">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="modal fade text-left" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-edit mr-1"></i> Update Coupon</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editCouponForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="coupon_id" id="edit_coupon_id">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Coupon Code *</label>
                            <div class="input-group">
                                <input type="text" name="code" id="edit_code" class="form-control" required>
                                <button type="button" class="btn btn-secondary btn-sm" id="generateEditCode">Generate</button>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Type *</label>
                            <select name="type" id="edit_type" class="form-control" required>
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group" id="editMinAmountField">
                            <label>Minimum Amount *</label>
                            <input type="number" name="minimum_amount" id="edit_minimum_amount" class="form-control" step="any">
                        </div>

                        <div class="col-md-6 form-group">
                            <label id="editAmountLabel">Amount *</label>
                            <input type="number" name="amount" id="edit_amount" class="form-control" step="any" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Qty *</label>
                            <input type="number" name="quantity" id="edit_quantity" class="form-control" step="any" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Expired Date</label>
                            <input type="date" name="expired_date" id="edit_expired_date" class="form-control">
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    return confirm("Are you sure want to delete?");
}

// Coupon Code Generate
document.getElementById('generateCode').addEventListener('click', function() {
    const code = 'A' + Math.random().toString(36).substr(2, 9).toUpperCase();
    document.getElementById('couponCode').value = code;
});
document.getElementById('generateEditCode').addEventListener('click', function() {
    const code = 'A' + Math.random().toString(36).substr(2, 9).toUpperCase();
    document.getElementById('edit_code').value = code;
});

// Populate Edit Modal
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const coupon = this.dataset;
        document.getElementById('edit_coupon_id').value = coupon.id;
        document.getElementById('edit_code').value = coupon.code;
        document.getElementById('edit_type').value = coupon.type;
        document.getElementById('edit_amount').value = coupon.amount;
        document.getElementById('edit_minimum_amount').value = coupon.minimum_amount;
        document.getElementById('edit_quantity').value = coupon.quantity;
        document.getElementById('edit_expired_date').value = coupon.expired_date;
        
        // Set form action dynamically
        const form = document.getElementById('editCouponForm');
        form.action = '/coupons/' + coupon.id;
        
        toggleEditFields();
    });
});

// Toggle fields dynamically
function toggleFields() {
    const typeSelect = document.getElementById('couponType');
    const minAmountField = document.getElementById('minAmountField');
    const amountLabel = document.getElementById('amountLabel');
    if(typeSelect.value === 'percentage') {
        minAmountField.style.display = 'none';
        amountLabel.textContent = 'Amount % *';
    } else {
        minAmountField.style.display = 'block';
        amountLabel.textContent = 'Amount $ *';
    }
}
function toggleEditFields() {
    const typeSelect = document.getElementById('edit_type');
    const minAmountField = document.getElementById('editMinAmountField');
    const amountLabel = document.getElementById('editAmountLabel');
    if(typeSelect.value === 'percentage') {
        minAmountField.style.display = 'none';
        amountLabel.textContent = 'Amount % *';
    } else {
        minAmountField.style.display = 'block';
        amountLabel.textContent = 'Amount $ *';
    }
}

document.getElementById('couponType').addEventListener('change', toggleFields);
document.getElementById('edit_type').addEventListener('change', toggleEditFields);
document.addEventListener('DOMContentLoaded', function(){
    toggleFields();
    toggleEditFields();
});
</script>
@endsection
