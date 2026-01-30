@extends('companyAdmin.layouts.master')
@section('page-title')
Sales List
@endsection
@section('main-content')
<style>
.purchase-attachment{
    height:40px;
    width:50px;
}
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
                        <h3 class="card-title">Purchase List</h3>
                        <!-- Add Create New Button -->
                        <a href="{{ route('company-purchase.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Create New
                        </a>
                    </div>
                 
                    <hr>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vendor</th>
                                    <th>Purchased Item Name</th> 
                                    <th>Cost </th>
                                    <th>Attachment</th>
                                    <th>Action</th>
                                </tr> 
                            </thead>
                            <tbody>
                                
                                @foreach($purchases as $key => $purchase)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$purchase->purchased_item_name}}</td>
                                        <td>{{$purchase->vendor->name}}</td>
                                        <td>{{$purchase->cost}}</td>
                                        <td class="text-center">
                                            <a href="{{ asset('uploads/'.$purchase->attachment) }}" target="_blank">
                                            <img src="{{ asset('uploads/'.$purchase->attachment) }}" class="img-thumbnail purchase-attachment" />
                                        </a>
                                         
                                        </td>
                                 
                                       <td >
                                            <a href="{{ route('company-purchase.edit', $purchase->id) }}" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('company-purchase.delete', $purchase->id) }}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Delete This ??')"><i class="fa fa-trash"></i></a>
                                        </td>
                                      
                                    </tr>
                                @endforeach
            
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-4">
                          {{--  {{ $sales->links() }} --}}
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

@endsection
