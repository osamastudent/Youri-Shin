@extends('admin.layouts.master')

@section('main-content')
<div class="card p-3 shadow-sm">
    <h4 class="mb-3">Add New Guide</h4>

    {{-- Display error alert --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.guides.store') }}" method="POST">
        @csrf

        {{-- YouTube Video Link --}}
        <div class="mb-3">
            <label class="form-label">Enter YouTube Video Link</label>
            <input 
                type="url" 
                name="video" 
                value="{{ old('video') }}" 
                class="form-control @error('video') is-invalid @enderror" 
                required 
                placeholder="https://www.youtube.com/watch?v=XXXXXX">

            @error('video')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Select role_type --}}
        <div class="mb-3">
            <label class="form-label">Select role_type</label>
            <select 
                name="role_type" 
                class="form-control @error('role_type') is-invalid @enderror" 
                required>
                <option value="">-- Select role_type --</option>
                <option value="company_admin" {{ old('role_type') == 'company_admin' ? 'selected' : '' }}>Company Admin</option>
                <option value="rider" {{ old('role_type') == 'rider' ? 'selected' : '' }}>Staff</option>
                <option value="user" {{ old('role_type') == 'user' ? 'selected' : '' }}>User</option>
            </select>

            @error('role_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Save Guide</button>
    </form>
</div>
@endsection
