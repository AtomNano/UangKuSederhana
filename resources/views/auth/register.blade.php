@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="row justify-content-center mt-5"><div class="col-md-5">
<div class="card"><div class="card-header text-center bg-white border-0 pt-4"><h4 class="fw-bold">Buat Akun Baru</h4></div>
<div class="card-body px-4 pb-4">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3"><label for="name" class="form-label">Nama Lengkap</label><input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label for="email" class="form-label">Alamat Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label for="password-confirm" class="form-label">Konfirmasi Password</label><input type="password" class="form-control" id="password-confirm" name="password_confirmation" required></div>
        <div class="d-grid"><button type="submit" class="btn btn-primary">Register</button></div>
    </form>
    <p class="text-center text-muted mt-3 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
</div></div></div></div>
@endsection