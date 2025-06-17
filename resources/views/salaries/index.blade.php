
@extends('layouts.app')
@section('title', 'Daftar Gaji')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Gaji Bulanan</h5>
            <a href="{{ route('salaries.create') }}" class="btn btn-primary">Input Gaji Baru</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Bulan</th>
                            <th>Nominal Gaji</th>
                            <th>Tabungan (10%)</th>
                            <th>Sisa Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salaries as $salary)
                        <tr>
                            <td>{{ $salary->created_at->format('F Y') }}</td>
                            <td>Rp {{ number_format($salary->amount, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($salary->amount * 0.1, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($salary->amount * 0.9, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data gaji.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection