@extends('admin.layouts.master')

@section('main-content')

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
        height:16px;
        top: 3px;
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
        height: 12px; 
        width: 16px;  
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
    <h1 class="page-header-title text-bold">Subscription Management</h1>

    {{-- <div class="mb-4">
        <span class="badge bg-primary total-companies-badge rounded-pill px-4 py-2 shadow-sm">
            Total Companies: {{ $companies->count() }}
        </span>
    </div> --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
  
    <div class="table-responsive m-t-40">
        <table id="table1" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-start" width="5%">#</th>
                    <th class="text-start" width="25%">Company Details</th>
                    <th class="text-start" width="35%">Subscription Frequencies</th>
                    <th class="text-start" width="35%">Control Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $index => $company)
                    <tr>
                        <td class="fw-bold text-center">{{ $index + 1 }}</td>

                        <td>
                            <div class="company-name">{{ $company->name }}</div>
                            <div class="company-meta">
                                Member Since: {{ $company->created_at->format('M d, Y') }}
                            </div>
                        </td>

                        <td>
                            @foreach($company->userSubscriptions as $sub)
                                <div class="freq-box">
                                    <div class="freq-title">{{ $sub->subscriptionData->frequency ?? 'N/A' }}</div>
                                  {{--  <div class="freq-meta">
                                        Updated: {{ $sub->updated_at->format('M d, Y H:i') }} | ID: {{ $sub->id }}
                                    </div> --}}
                                </div>
                            @endforeach
                        </td>

                        <td class="text-center align-middle">
                            <div class="status-control-wrapper d-inline-block text-center">
                                @foreach($company->userSubscriptions as $sub)
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <span class="me-3 text-capitalize" style="min-width: 70px;">
                                            {{ ucfirst($sub->subscriptionData->frequency) }}
                                        </span>
                        
                                        <form method="POST" action="{{ route('admin.subscriptions.ajaxToggle', $sub->id) }}" class="m-0 p-0 d-flex align-items-center">
                                            @csrf
                                            <label class="switch mb-0 me-2">
                                                <input type="checkbox" name="status"
                                                    onchange="this.form.submit()"
                                                    {{ $sub->status === 'active' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </form>
                        
                                        <span class="badge {{ $sub->status === 'active' ? 'bg-active' : 'bg-inactive' }}">
                                            {{ $sub->status === 'active' ? 'Activated' : 'Deactivated' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted text-center py-5">
                            <i class="fas fa-box-open me-2"></i> No companies or subscriptions found.
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
</div>
@endsection