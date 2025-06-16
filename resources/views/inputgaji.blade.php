@extends('layouts.app')
@section('title', 'Input Gaji')
@section('content')
<div class="container">
    <h3 class="mb-3">Input Gaji Bulanan</h3>
    <form action="{{ route('salaries.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Nominal Gaji</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('salaries.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection