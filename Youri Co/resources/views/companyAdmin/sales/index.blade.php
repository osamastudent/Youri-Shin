@extends('companyAdmin.layouts.master')
@section('page-title')
Sales List
@endsection
@section('main-content')
<style>
    .container-fluid {
        padding: 8px; /* Increase padding for the main container */
    }
    
    .badge-ordered {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #17a2b8; /* Teal background */
        color: #ffffff; /* White text */
    }
    
    .badge-assigned {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #fb9678; /* Green background */
        color: #ffffff; /* White text */
    }
    
    .badge-in-process {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #ffc107; /* Yellow background */
        color: #ffffff; /* White text */
    }
    
    .badge-delivering {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #007bff; /* Blue background */
        color: #ffffff; /* White text */
    }
    
    .badge-delivered {
        display: inline-block;
        padding: 0.5em 0.5em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #28a745; /* Green background */
        color: #ffffff; /* White text */
    }

    .item-names {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        position: relative;
        max-width: 200px;
        cursor: pointer;
    }

    .hover-card {
        display: none;
        position: absolute;
        background-color: white;
        box-shadow: 0 20px 40px rgba(1, 192, 200, 0.1);
        border: 2px solid #01c0c8;
        z-index: 10;
        padding: 10px;
        border-radius: 4px;
        width: 200px;
        margin-top: -150px;
        margin-left: -60px;
        transition: border-color 0.3s ease;
    }

    .hover-card ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .hover-card ul li {
        margin: 5px 0;
    }

    .table-responsive {
        overflow-x: auto; /* Ensure table responsiveness */
    }

    table {
        width: 100%; /* Ensure table fits within the container */
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">Order List</h3>
                        <!-- Add Create New Button -->
                        <a href="{{ route('company-sale.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Create New
                        </a>
                    </div>
                    <!-- Date Filter Form -->
                    <form method="GET" action="{{ route('company-sale.index') }}" class="row mb-3">
                        <div class="col-md-4">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </form>
                    <hr>
                    
                    <!-- Status Filter Buttons -->
                    
                            <div class="d-flex flex-wrap justify-content-start align-items-center mb-3" style="justify-content: space-evenly !important;">
                                <a href="{{ route('company-sale.index') }}"
                                   class="btn btn-outline-secondary me-2 mb-2 {{ request('status') === null ? 'active' : '' }}">
                                    All
                                </a>
                                <a href="{{ route('company-sale.index', ['status' => 0]) }}"
                                   class="btn badge-ordered me-2 mb-2 {{ request('status') == 0 ? 'active' : '' }}">
                                    Ordered
                                </a>
                                <a href="{{ route('company-sale.index', ['status' => 1]) }}"
                                   class="btn badge-assigned me-2 mb-2 {{ request('status') == 1 ? 'active' : '' }}">
                                    Assigned
                                </a>
                                <a href="{{ route('company-sale.index', ['status' => 2]) }}"
                                   class="btn badge-in-process me-2 mb-2 {{ request('status') == 2 ? 'active' : '' }}">
                                    Preparing
                                </a>
                                <a href="{{ route('company-sale.index', ['status' => 3]) }}"
                                   class="btn badge-delivering me-2 mb-2 {{ request('status') == 3 ? 'active' : '' }}">
                                    Dispatched
                                </a>
                                <a href="{{ route('company-sale.index', ['status' => 4]) }}"
                                   class="btn badge-delivered me-2 mb-2 {{ request('status') == 4 ? 'active' : '' }}">
                                    Delivered
                                </a>
                            </div>

                    
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Customer</th>
                                    <th>Bill</th>
                                    <th>Rec</th>
                                    <th>Due</th>
                                    <th>Zone</th>
                                    <th>Delivery Staff</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $key => $item)
                                    <tr>
                                        <td>#{{ $item->id }}</td>
                                        <td>{{ $item->customer_name }}</td>
                                        <td>Rs: {{ $item->total_amount }}/=</td>
                                        <td>Rs: {{ $item->cash_received }}/=</td>
                                        <td>Rs: {{ $item->balance }}/=</td>
                                        <td>{{ $item->zone }}</td>
                                        <td>
                                            @if($item->status == 0)
                                                <select name="staff_id" id="staff_id_{{ $item->id }}" class="form-control select2" onchange="showCheckButton({{ $item->id }})" style="font-size: 13px;">
                                                    <option value="">Select Staff</option>
                                                    @foreach ($staffs as $staff)
                                                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif(in_array($item->status, [1, 2, 3, 4]))
                                                @php
                                                    $assignedStaff = $staffs->firstWhere('id', $item->staff_id);
                                                @endphp
                                                <p>Assigned To {{ $assignedStaff ? $assignedStaff->name : 'Unknown' }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 0)             
                                                <span class="badge-ordered">Ordered</span>
                                            @elseif ($item->status == 1)
                                                <span class="badge-assigned">Assigned</span>
                                            @elseif ($item->status == 2)
                                                <span class="badge-in-process">Preparing</span>
                                            @elseif ($item->status == 3)
                                                <span class="badge-delivering">Dispatched</span>
                                            @elseif ($item->status == 4)
                                                <span class="badge-delivered">Delivered</span>
                                            @endif
                                        </td>
                                        <td style="display: flex; gap: 5px; flex-wrap: wrap;">

                                                <!-- View Sale -->
                                                <a href="{{ route('company-sale.show', $item->id) }}" class="btn btn-secondary btn-sm" title="View Sale">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                
                                                <!-- Print Invoice -->
                                                <a href="{{ route('sale.invoice', $item->id) }}" class="btn btn-warning btn-sm" title="Print Invoice" target="_blank">
                                                   <i class="fa-solid fa-file-invoice"></i>view
                                            
                                                </a>
                                                
                                                <!-- Download PDF -->
                                                <a href="{{ route('sales.invoice.download', $item->id) }}" class="btn btn-primary btn-sm" title="Download PDF">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                
                                                <!-- View QR Code -->
                                                @if($item->qr_code_path)
                                                    <a href="{{ route('sale.qrcode.view', $item->id) }}" class="btn btn-info btn-sm" title="View QR Code" target="_blank">
                                                        <i class="fa fa-qrcode"></i>
                                                    </a>
                                                @endif
                                                
                                                <!-- Status Change Form -->
                                                <form action="{{ route('company-sale.statusChange', $item->id) }}" class="d-none dynamicCheck" data-id="{{$item->id}}" method="get">
                                                    @csrf
                                                    <input type="hidden" name="staff_id" class="staff_id_pass" value="" />
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            
                                                <!-- Status Change Button (dynamic trigger) -->
                                                <a href="{{ route('company-sale.statusChange', $item->id) }}" class="btn btn-success btn-sm d-none dynamicCheck" data-id="{{$item->id}}" title="Mark as Done">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            
                                                <!-- Delete / Status Indicator -->
                                                @if($item->status == 0)
                                                    <a href="{{ route('company-sale.delete', $item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure You Want To Delete This?')" title="Delete Sale">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-success btn-sm" title="Completed">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                @endif
                                            
                                            </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       <div class="d-flex justify-content-center mt-4">
                            {{ $sales->appends(request()->query())->links('pagination::bootstrap-5') }}
                      </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
 document.addEventListener('DOMContentLoaded', function() {
    const itemNames = document.querySelectorAll('.item-names');

    itemNames.forEach(item => {
        item.addEventListener('mouseenter', function(event) {
            const items = this.getAttribute('data-items');
            const hoverCard = document.querySelector('.hover-card');

            // Position the hover card directly above the hovered item
            const rect = event.target.getBoundingClientRect();
            const topPos = rect.top + window.scrollY - hoverCard.offsetHeight;

            hoverCard.innerHTML = `<ul>${items.split(',').map(item => `<li>${item}</li>`).join('')}</ul>`;
            hoverCard.style.top = `${topPos}px`;
            hoverCard.style.left = `${rect.left + window.scrollX}px`;
            hoverCard.style.display = 'block';
        });

        item.addEventListener('mouseleave', function() {
            const hoverCard = document.querySelector('.hover-card');
            hoverCard.style.display = 'none';
        });
    });

    @if(session('success'))
        let msg = "{{ session('success') }}";
        speak(msg);
    @endif
});

function showCheckButton(itemId) {
     var button = document.querySelector('.dynamicCheck[data-id="' + itemId + '"]');
 var dropdown = document.getElementById('staff_id_' + itemId);
    var selectedValue = dropdown.value;

    // Get the corresponding input field using the itemId
    var inputField = document.querySelector('.dynamicCheck[data-id="' + itemId + '"] .staff_id_pass');
    if (inputField) {
        // Append the selected value to the input field, separated by a comma
        if (inputField.value) {
            inputField.value += ',' + selectedValue;
        } else {
            inputField.value = selectedValue;
        }
    } else {
        console.error("Input field not found for itemId:", itemId);
    }
    
    // If the button exists, remove the 'd-none' class
    if (button) {
        button.classList.remove('d-none');
    }
    const selectedStaff = document.getElementById(`staff_id_${itemId}`).value;
    const checkButton = document.getElementById(`check_button_${itemId}`);
    if (selectedStaff !== "") {
        checkButton.style.display = "inline-block";
        
    } else {
        checkButton.style.display = "none";
    }
}

function speak(text) {
    const msg = new SpeechSynthesisUtterance();
    msg.text = text;
    window.speechSynthesis.speak(msg);
}
</script>

<script>
function downloadInvoicePDF() {
    const originalTitle = document.title;

    @if (isset($item))
        document.title = "Invoice-{{ $item->order_unique_id ?? $item->id }}";
    @else
        document.title = "Invoice";
    @endif

    window.print();

    setTimeout(() => {
        document.title = originalTitle;
    }, 1000);
}
</script>



@endsection
