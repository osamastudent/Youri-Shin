@extends('admin.layouts.master')
@section('page-title')
    Banners Details
@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Banners Details</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="/uploads/{{ $banners->banner_img }}" alt="Banner Image" style="max-width: 200px;" class="img-thumbnail">
                            </div>
                        </div><br><br>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong class="text-info">Banner Name:</strong> {{ $banners->name }}</p>
                                
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('company-banners.index') }}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
