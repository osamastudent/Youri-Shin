@extends('companyAdmin.layouts.master')
@section('page-title')
    Dashboard
@endsection
@section('main-content')
    <div class="container-fluid">
        
        <!-- Chart Row -->
       
       
      <div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs" id="filterTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="today-tab" data-bs-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true">Today</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="this-week-tab" data-bs-toggle="tab" href="#thisWeek" role="tab" aria-controls="thisWeek" aria-selected="false">This Week</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="this-month-tab" data-bs-toggle="tab" href="#thisMonth" role="tab" aria-controls="thisMonth" aria-selected="false">This Month</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="this-year-tab" data-bs-toggle="tab" href="#thisYear" role="tab" aria-controls="thisYear" aria-selected="false">This Year</a>
            </li>
        </ul>
    </div>
<div class="card-body">
    <div class="tab-content" id="filterTabsContent">
        <!-- Today Tab -->
        <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">
            <div class="row justify-content-center">
                @foreach (['sales', 'receive', 'due', 'expense', 'purchase', 'profit'] as $key)
                    <div class="col-md-2 col-sm-4 col-6 mb-4">
                        <div class="card shadow-sm border rounded h-100">
                            <div class="card-body text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <h3 class="text-primary mb-3">
    {{ ucfirst($key) }}
</h3>
                                    
                                    <h2 class="counter text-primary mt-2">{{ $data['today'][$key] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- This Week Tab -->
        <div class="tab-pane fade" id="thisWeek" role="tabpanel" aria-labelledby="this-week-tab">
            <div class="row justify-content-center">
                @foreach (['sales', 'receive', 'due', 'expense', 'purchase', 'profit'] as $key)
                    <div class="col-md-2 col-sm-4 col-6 mb-4">
                        <div class="card shadow-sm border rounded h-100">
                            <div class="card-body text-center">
                                <div class="d-flex flex-column align-items-center">
                                          <h3 class="text-primary mb-3">
                                            {{ ucfirst($key) }}
                                        </h3>
                                    <h2 class="counter text-primary mt-2">{{ $data['thisWeek'][$key] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- This Month Tab -->
        <div class="tab-pane fade" id="thisMonth" role="tabpanel" aria-labelledby="this-month-tab">
            <div class="row justify-content-center">
                @foreach (['sales', 'receive', 'due', 'expense', 'purchase', 'profit'] as $key)
                    <div class="col-md-2 col-sm-4 col-6 mb-4">
                        <div class="card shadow-sm border rounded h-100">
                            <div class="card-body text-center">
                                <div class="d-flex flex-column align-items-center">
                                   <h3 class="text-primary mb-3">
    {{ ucfirst($key) }}
</h3>
                                    
                                    <h2 class="counter text-primary mt-2">{{ $data['thisMonth'][$key] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- This Year Tab -->
        <div class="tab-pane fade" id="thisYear" role="tabpanel" aria-labelledby="this-year-tab">
            <div class="row justify-content-center">
                @foreach (['sales', 'receive', 'due', 'expense', 'purchase', 'profit'] as $key)
                    <div class="col-md-2 col-sm-4 col-6 mb-4">
                        <div class="card shadow-sm border rounded h-100">
                            <div class="card-body text-center">
                                <div class="d-flex flex-column align-items-center">
                                   <h3 class="text-primary mb-3">
                                        {{ ucfirst($key) }}
                                    </h3>
                                    <h2 class="counter text-primary mt-2">{{ $data['thisYear'][$key] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



</div>



<div class="card-group">
            <!-- Customers Card -->
            <div class="card mx-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h3><i class="fa fa-users text-primary"></i></h3>
                                    <p class="text-muted">Customers</p>
                                </div>
                                <div class="ml-auto">
                                    <h2 class="counter text-primary">{{ $customerCount }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-cyan" role="progressbar" style="width: {{ $customerCount > 100 ? 100 : $customerCount }}%; height: 15px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Staff Card -->
            <div class="card mx-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h3><i class="fa fa-user"></i></h3>
                                    <p class="text-muted">Staff</p>
                                </div>
                                <div class="ml-auto">
                                    <h2 class="counter text-dark">{{ $staffCount }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-dark" role="progressbar" style="width: {{ $staffCount > 100 ? 100 : $staffCount }}%; height: 15px;" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Orders Card -->
            <div class="card mx-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h3><i class="fa fa-cart-plus text-purple"></i></h3>
                                    <p class="text-muted">Orders</p>
                                </div>
                                <div class="ml-auto">
                                    <h2 class="counter text-purple">{{ $orderCount }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: {{ $orderCount > 100 ? 100 : $orderCount }}%; height: 15px;" aria-valuenow="{{ $orderCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Delivered Orders Card -->
            <div class="card mx-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h3><i class="fa fa-truck text-success"></i></h3>
                                    <p class="text-muted">Delivered Orders</p>
                                </div>
                                <div class="ml-auto">
                                    <h2 class="counter text-success">{{ $delieverOrderCount }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $delieverOrderCount > 100 ? 100 : $delieverOrderCount }}%; height: 15px;" aria-valuenow="{{ $delieverOrderCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
       <div class="card">
    <div class="card-header">Monthly Overview</div>
    <div class="card-body">
      
        <canvas id="monthlyPieChart" style="max-width: 300px; max-height: 300px; margin: auto;"></canvas>
          <canvas id="yearlyReportChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('monthlyPieChart').getContext('2d');
        const data = {
            labels: ['Sales', 'Expenses', 'Purchases'],
            datasets: [{
                data: [{{ $totalSales }}, {{ $totalExpenses }}, {{ $totalPurchases }}],
                backgroundColor: ['#00D1D1', '#3C4142', '#77DD77'],
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            },
        });
    });
</script>

     

<script>
    var ctx = document.getElementById('yearlyReportChart').getContext('2d');
    var yearlyReportChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            datasets: [{
                label: 'Sales',
                data: salesData,
                backgroundColor: '#00D1D1',  // Set Sales color
                borderColor: '#00D1D1',      // Set Sales border color
                borderWidth: 1
            },
            {
                label: 'Amount Received',
                data: receivedData,
                backgroundColor: '#77DD77',  // Set Amount Received color
                borderColor: '#77DD77',      // Set Amount Received border color
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

       
@endsection

<style>
    .box {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        height: 100px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .nav-tabs .nav-link {
        font-weight: bold;
    }
</style>
<script>
    var salesData = @json($yearlySalesData);
    var receivedData = @json($yearlyReceivedData);
</script>

