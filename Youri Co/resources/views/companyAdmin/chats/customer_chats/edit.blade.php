@extends('companyAdmin.layouts.master')

@section('page-title')
    Brand
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-brand.update', $brand->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Brand Edit</h3>
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $brand->name }}">
                                        @error('name')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Category Image</label>
                                        @if ($brand->brand_image)
                                            <div class="form-group">
                                                <div>
                                                    <img src="/uploads/{{ $brand->brand_image }}" alt="Brand Image" class="img-thumbnail img-fluid rounded">
                                                </div>
                                            </div>
                                        @endif
                                        <input type="file" name="brand_image" id="brand_image" class="form-control">
                                        @error('brand_image')
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
