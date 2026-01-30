@extends('admin.layouts.master')
@section('page-title')
    Dashboard
@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h3><i class="fa fa-users text-primary"></i></h3>
                                    <p class="text-muted">Companies</p>
                                </div>
                                <div class="ml-auto">
                                    <h2 class="counter text-primary">{{ $companyCount }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-cyan" role="progressbar" style="width: {{ $companyCount > 100 ? 100 : $companyCount }}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex m-b-40 align-items-center no-block">
                            <h5 class="card-title"></h5>
                            <div class="ml-auto">
                                <ul class="list-inline font-12">
                                    <li><i class="fa fa-circle text-cyan"></i> Companies</li>
                                </ul>
                            </div>
                        </div>
                        <canvas id="dashboardChart" width="500" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <script>
    var ctx = document.getElementById('dashboardChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line', // Change to line chart
        data: {
            labels: ['Companies'],
            datasets: [{
                label: 'Company Count',
                data: [{{ $companyCount }}],
                backgroundColor: 'rgba(0, 0, 0, 0.1)', // Cyan color
                borderColor: 'rgba(75, 192, 192, 1)', // Dark Blue color
                borderWidth: 2,
                fill: true // Fill area under the line
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: 'rgba(0, 0, 0, 0.8)',
                        fontFamily: 'Arial'
                    },
                    gridLines: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontColor: 'rgba(0, 0, 0, 0.8)',
                        fontFamily: 'Arial'
                    },
                    gridLines: {
                        color: 'rgba(0, 0, 0, 0)'
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });
    </script>
@endsection
