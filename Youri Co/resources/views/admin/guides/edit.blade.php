@extends('admin.layouts.master')

@section('main-content')
<div class="container mt-4">
    <h4>Edit Guide</h4>
    <form action="{{ route('guides.update', $guide->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ $guide->title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4">{{ $guide->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Role Type</label>
            <select name="role_type" class="form-control" required>
                <option value="company_admin" {{ $guide->role_type == 'company_admin' ? 'selected' : '' }}>Company Admin</option>
                <option value="user" {{ $guide->role_type == 'user' ? 'selected' : '' }}>User</option>
                <option value="rider" {{ $guide->role_type == 'rider' ? 'selected' : '' }}>Rider</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            @if($guide->image)
                <img src="{{ asset('storage/'.$guide->image) }}" width="100" class="mb-2 rounded"><br>
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Current Video</label><br>
            @if($guide->video)
                <video width="150" controls class="mb-2">
                    <source src="{{ asset('storage/'.$guide->video) }}">
                </video><br>
            @endif
            <input type="file" name="video" class="form-control">
        </div>

        <button class="btn btn-primary">Update Guide</button>
        <a href="{{ route('guides.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
