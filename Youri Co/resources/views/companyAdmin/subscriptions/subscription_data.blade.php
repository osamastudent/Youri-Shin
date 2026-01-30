@extends('companyAdmin.layouts.master')

@section('main-content')

{{-- Simple toggle switch style --}}
<style>

#table1{
justify-content:center;
align-items:center;
text-align:center;
}



    .switch-container {
        position: relative;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 40px;  
        height: 20px; 
    }

    .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        
        position: absolute;
        cursor: pointer;
        height:20px;
        width: auto;
        top: 1px;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 10px; 
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px; 
        width: 15px;  
        left: 2px;    
        bottom: 2px;  
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%; 
    }

    input:checked + .slider {
        background-color: #01C0C8;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #01C0C8;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(20px); 
        -ms-transform: translateX(20px); 
        transform: translateX(20px); 
    }

    .badge {
        position: 
        top: 3px; 
        margin-left: 10px; 
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Subscription Data</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                     <div class="table-responsive m-t-40">
                         <table id="table1" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Frequency</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $key => $sub)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        
                                        @php                                  
                                        $subscriptionid = \App\Models\SubscriptionData::where('id',$sub->subscription_data_id )->first();
                                        @endphp
                                        
                                        <td>{{ $subscriptionid->frequency }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('company-subscriptions.toggle', $sub->id) }}">
                                                @csrf
                                                <label class="switch">
                                                    <input type="checkbox" name="status"
                                                        onchange="this.form.submit()"
                                                        {{ $sub->status === 'active' ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                                <span class="badge {{ $sub->status === 'active' ? 'bg-success' : 'bg-black' }}" style=" background: #fa4d4d;">
                                                    {{ ucfirst($sub->status) }}
                                                </span>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($subscriptions->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-muted py-3">
                                            No subscription data found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
