@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Saved Passwords</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('passwords.store') }}" method="POST">
        @csrf
        <input type="text" name="site_name" placeholder="Website" required class="form-control mb-2">
        <input type="text" name="username" placeholder="Username (Optional)" class="form-control mb-2">
        <button type="submit" class="btn btn-primary">Generate & Save</button>
    </form>

    <ul class="list-group mt-3">
        @foreach($passwords as $password)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $password->site_name }} - <a href="{{ route('passwords.show', $password->id) }}">View</a></span>
                <form action="{{ route('passwords.destroy', $password->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
