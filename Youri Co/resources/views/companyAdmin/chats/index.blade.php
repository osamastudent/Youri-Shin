@extends('companyAdmin.layouts.master')

@section('page-title')
Chat
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Chat With Staff Members</h3>
            <ul class="list-group">
                @foreach($staffMembers as $staff)
                    <li class="list-group-item">
                        <a href="{{ route('company-chat.show', ['id' => $staff->id]) }}" class="staff-link">
                            {{ $staff->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
