@extends('companyAdmin.layouts.master')

@section('page-title')
    Banners
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-banners.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Banners Info</h3>
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        @error('name')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Banner Image (360x460 pixels)</label>
                                        <input type="file" name="banner_img" id="banner_img" class="form-control @error('banner_img') is-invalid @enderror" value="{{ old('banner_img') }}">
                                        @error('banner_img')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                
                                
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-actions mt-5">
                            <!-- Clear Button -->
                                    <a href="{{ route('company-banners.index') }}" type="button" class="btn btn-inverse">Cancel</a>
                            </button>

                             <!--Post Button   -->
                            <button type="submit" class="btn btn-primary" id="postButton" >
                                Save
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Include Sweet Alert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
