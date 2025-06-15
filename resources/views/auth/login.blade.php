@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="row justify-content-center mt-5"><div class="col-md-5">
<div class="card"><div class="card-header text-center bg-white border-0 pt-4"><h4 class="fw-bold">Login Akun</h4></div>
<div class="card-body px-4 pb-4">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3"><label for="email" class="form-label">Alamat Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" class="form-control" id="password" name="password" required></div>
        <div class="mb-3 form-check"><input type="checkbox" class="form-check-input" id="remember" name="remember"><label class="form-check-label" for="remember">Ingat saya</label></div>
        <div class="d-grid"><button type="submit" class="btn btn-primary">Login</button></div>
    </form>
    <p class="text-center text-muted mt-3 mb-0">Belum punya akun? <a href="{{ route('register') }}">Register di sini</a></p>
</div></div></div></div>
@endsection