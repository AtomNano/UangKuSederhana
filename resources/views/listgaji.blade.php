@extends('layouts.app')
@section('title', 'Daftar Gaji')
@section('content')
<div class="container">
    <h3 class="mb-3">Daftar Gaji Bulanan</h3>
    <a href="{{ route('salaries.create') }}" class="btn btn-primary mb-3">Input Gaji Baru</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Nominal Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaries as $salary)
            <tr>
                <td>{{ $salary->created_at->format('F Y') }}</td>
                <td>Rp {{ number_format($salary->amount,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection