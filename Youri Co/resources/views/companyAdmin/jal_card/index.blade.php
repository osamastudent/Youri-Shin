@extends('companyAdmin.layouts.master')

@section('main-content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-id-card mr-2"></i> Jal Cards</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus-circle mr-1"></i> Add New Card
            </button>
        </div>

        <div class="card-body">
            <table id="jalCardTable" class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Card No</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Expense</th>
                        <th>Expired Date</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lims_jal_card_all as $key => $card)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $card->card_no }}</td>
                        <td>{{ optional($card->customer)->name }}</td>
                        <td>{{ number_format($card->amount, 2) }}</td>
                        <td>{{ number_format($card->expense, 2) }}</td>
                        <td>{{ $card->expired_date ? \Carbon\Carbon::parse($card->expired_date)->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            @if($card->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" onclick="openEditModal({{ $card }})"><i class="fa fa-edit"></i></button>
                  {{--          <button class="btn btn-sm btn-info" onclick="openRechargeModal({{ $card->id }})"><i class="fa fa-coins"></i></button>  --}}
                            <button class="btn btn-sm btn-danger" onclick="openDeleteModal({{ $card->id }})"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- =================== Add Jal Card Modal =================== --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('jal_cards.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i> Add Jal Card</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label>Card Number (Auto-generated)</label>
              <input type="text" id="autoCardNo" name="card_no" class="form-control" value="{{ $generatedCardNo }}" readonly required>
            </div>
            <div class="col-md-6">
              <label>Amount *</label>
              <input type="number" name="amount" class="form-control" step="0.01" required>
            </div>
            <div class="col-md-6">
              <label>Customer (Optional)</label>
              <select name="customer_id" class="form-control">
                <option value="">-- Select Customer --</option>
                @foreach($lims_customer_list as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label>Expired Date</label>
              <input type="date" name="expired_date" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Active Status *</label>
              <select name="is_active" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Card</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- =================== Edit Jal Card Modal =================== --}}
<div class="modal fade" id="editJalCardModal" tabindex="-1" aria-labelledby="editJalCardLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editJalCardForm" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><i class="fa fa-edit me-2"></i> Edit Jal Card</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_card_id" name="jal_card_id">
          <div class="row g-3">
            <div class="col-md-6">
              <label>Card Number</label>
              <input type="text" id="edit_card_no" name="card_no" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Amount</label>
              <input type="number" id="edit_amount" name="amount" step="0.01" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Customer</label>
              <select id="edit_customer_id" name="customer_id" class="form-select">
                <option value="">Select Customer</option>
                @foreach ($lims_customer_list as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label>Expiry Date</label>
              <input type="date" id="edit_expired_date" name="expired_date" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- =================== Recharge Jal Card Modal =================== --}}
<div class="modal fade" id="rechargeJalCardModal" tabindex="-1" aria-labelledby="rechargeJalCardLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="rechargeJalCardForm" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title"><i class="fa fa-plus-circle me-2"></i> Recharge Jal Card</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="recharge_card_id" name="jal_card_id">
          <label>Recharge Amount</label>
          <input type="number" id="recharge_amount" name="amount" step="0.01" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Recharge</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- =================== Delete Jal Card Modal =================== --}}
<div class="modal fade" id="deleteJalCardModal" tabindex="-1" aria-labelledby="deleteJalCardLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteJalCardForm" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title"><i class="fa fa-trash me-2"></i> Delete Jal Card</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this Jal Card?</p>
          <input type="hidden" id="delete_card_id" name="jal_card_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection


<script>
$(document).ready(function() {
    $('#jalCardTable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});

// Edit Modal
function openEditModal(card) {
    $('#edit_card_id').val(card.id);
    $('#edit_card_no').val(card.card_no);
    $('#edit_amount').val(card.amount);
    $('#edit_customer_id').val(card.customer_id);
    $('#edit_expired_date').val(card.expired_date);
    $('#editJalCardForm').attr('action', `/jal_cards/${card.id}`);
    $('#editJalCardModal').modal('show');
}

// Recharge Modal
function openRechargeModal(id) {
    $('#recharge_card_id').val(id);
    $('#rechargeJalCardForm').attr('action', `/jal_cards/${id}/recharge`);
    $('#rechargeJalCardModal').modal('show');
}

// Delete Modal
function openDeleteModal(id) {
    $('#delete_card_id').val(id);
    $('#deleteJalCardForm').attr('action', `/jal_cards/${id}`);
    $('#deleteJalCardModal').modal('show');
}

// Auto-generate Card Number when opening Add Modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('addModal');
    const cardNoInput = document.getElementById('autoCardNo');
    function generateCardNumber() {
        return Math.floor(1000000000 + Math.random() * 9000000000);
    }
    modal.addEventListener('show.bs.modal', function () {
        cardNoInput.value = generateCardNumber();
    });
});
</script>
