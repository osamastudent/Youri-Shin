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
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-banners.update', $banners->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Banners Edit</h3>
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $banners->name }}">
                                        @error('name')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Banner Image</label>
                                        @if ($banners->banner_img)
                                            <div class="form-group">
                                                <div>
                                                    <img src="/uploads/{{ $banners->banner_img }}" alt="Banner Image" class="img-thumbnail img-fluid rounded">
                                                </div>
                                            </div>
                                        @endif
                                        <input type="file" name="banner_img" id="banner_img" class="form-control">
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
                            <button type="button" class="btn btn-secondary" onclick="clearForm()">
                                Clear
                            </button>

                             <!-- Update Button -->
                            <button type="submit" class="btn btn-primary" id="postButton">
                                Update
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
