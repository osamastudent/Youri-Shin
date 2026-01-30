@extends('admin.layouts.master')

@section('main-content')
<div class="card p-3 shadow-sm">
    <h4 class="mb-3">Guides List</h4>
    
    
    
    <a href="{{ route('guides.create') }}" class="btn btn-primary mb-3"  style=" width: fit-content;">Add New Guide</a>

    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Serial No.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Thumbnail</th>
                <th>Role</th>
                <th>Link</th>
                <th>Video</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guides as $guide)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td> 
                <td>{{ $guide->title }}</td>
                <td>{{ Str::limit($guide->description, 60) }}</td>
                <td><img src="{{ $guide->image }}" width="80" class="rounded"></td>
                <td class="text-center">{{ ucfirst(str_replace('_',' ',$guide->role_type)) }}</td>
                <td>{{ $guide->video }}</td>
                <td><a href="{{ $guide->video }}" target="_blank" class="btn btn-sm btn-info">Watch</a></td>
                <td>
                    <form action="{{ route('guides.destroy', $guide) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this guide?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection