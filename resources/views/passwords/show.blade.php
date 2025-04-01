@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Password for {{ $password->site_name }}</h2>
    <p><strong>Username:</strong> {{ $password->username ?? 'N/A' }}</p>
    <p><strong>Password:</strong> <span class="text-danger">{{ $decryptedPassword }}</span></p>
    <a href="{{ route('passwords.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
